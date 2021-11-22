<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{   
    public function products(Request $request){
        $select = 'Quản lí sản phẩm';
        $active = 'products';
        $search = '';
        $categories = Category::all(['id','name']); 
        $products = Product::with('category')->paginate(15);

        if ($request->has('id')) {
            $product = Product::where('id',$request->input('id'))->first();
            $category = Category::where('id',$product->category_id)->first();
            return view('backend.main.product',compact('select','active','product','categories','category'));
        }

        if ($request->has(['category_id'])){
            $products = Category::findOrFail($request->input('category_id'))->products()->paginate(15);
            $products->appends(['category_id'=> $request->input('category_id')]);
        };
        if ($request->has(['search'])){
            $search = $request->input('search');
            $products = Product::where('name', 'LIKE', '%' . $request->input('search') . '%')->paginate(15);
            $products->appends(['search'=> $request->input('search')]);
        };
        return view('backend.main.product',compact('select','active','products','categories','search'));
    }
    public function import(Request $request) {   
        $request->validate([
        'mcafile' => 'max:10240|required|mimes:csv,xlsx'
        ]);
        $path = $request->file('mcafile')->getRealPath();
        // $path1 = $request->file('mcafile')->store('temp'); 
        // $path=storage_path('app').'/'.$path1;   
        $data = Excel::import(new ProductsImport,$path);
        return back();
    }
    public function create(Request $request){
        $name = $request->input('name');
        $desc = $request->input('desc');
        $category_id = $request->input('category_id');
        Product::insert([
            'name' => $name,
            'desc' => $desc,
            'category_id' => $category_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        session()->flash('success','Thêm sản phẩm thành công');
        return back();
    }
    public function mutipleDelete(Request $request){
        if ($request->ajax()){
            $password = $request->input('confirmPassword');
            if (Hash::check($password, Auth::guard('admin')->user()->password)){
                $ids = $request->input('mutipleId');
                foreach ($ids as $id){
                    $types = Product::findOrFail($id)->types()->get();
                    foreach ($types as $type){
                        $files = Type::findOrFail($type->id)->images()->get();
                        Type::findOrFail($type->id)->images()->delete();
                        foreach ($files as $file){
                            if (!filter_var($file->name, FILTER_VALIDATE_URL)){
                                Storage::disk('type-image')->delete($file->name);
                            }
                        }
                        Type::where('id', $type->id)->delete();
                    }
                    Product::where('id',$id)->delete();
                }
                session()->flash('success','Xóa sản phẩm thành công');
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                session()->flash('fail','Xóa sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu');
                return response()->json([
                    'result' => 'failed'
                ]);
            }
        }
    }
    public function delete(Request $request,$id){
        if( $request->ajax()){
            $password = $request->input('confirmPassword');
            if (Hash::check($password, Auth::guard('admin')->user()->password)){
                $types = Product::findOrFail($id)->types()->get();
                foreach ($types as $type){
                    $files = Type::findOrFail($type->id)->images()->get();
                    Type::findOrFail($type->id)->images()->delete();
                    foreach ($files as $file){
                        if (!filter_var($file->name, FILTER_VALIDATE_URL)){
                            Storage::disk('type-image')->delete($file->name);
                        }
                    }
                    Type::where('id', $type->id)->delete();
                }
                Product::where('id',$id)->delete();
                session()->flash('success','Xóa sản phẩm thành công');
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                session()->flash('fail','Xóa sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu');
                return response()->json([
                    'result' => 'failed'
                ]);
            }
            
        }
    }
    public function update(Request $request,$id){
        if( $request->ajax()){
            $name = $request->input('name');
            $desc = $request->input('desc');
            $category_id = $request->input('category_id');
            $result = Product::where('id', $id)->update([
                        'name' => $name,
                        'desc' => $desc,
                        'category_id' => $category_id,
                        'updated_at' => now()
                    ]);
            if ($result){
                session()->flash('success','Cập nhật sản phẩm thành công');
                return response()->json([
                    'result' => 'success',
                ]);
            }
        }
    }
}
