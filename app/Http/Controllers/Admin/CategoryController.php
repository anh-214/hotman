<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function categories(Request $request){
        $select = 'Quản lí thể loại';
        $active = 'categories';
        $categories = Category::paginate(15);
        $search = '';
        if ($request->has('id')) {
            $category = Category::where('id',$request->input('id'))->first();
            return view('backend.main.category',compact('select','active','category'));
        }
        if ($request->has('search')) {
            $search = $request->input('search');
            $categories = Category::where('name', 'LIKE', '%' . $request->input('search') . '%')->paginate(15);
            $categories->appends(['search'=> $request->input('search')]);
        }
        return view('backend.main.category',compact(['select','active','categories','search']));
    }
    public function mutipleDelete(Request $request){
        $password = $request->input('confirmPassword');
        if (Hash::check($password, Auth::guard('admin')->user()->password)){
            $ids = $request->input('mutipleId');
            foreach ($ids as $id){
                $products = Category::findOrFail($id)->products()->get();
                foreach ($products as $product){
                    $types = Product::findOrFail($product->id)->types()->get();
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
                    Product::where('id', $product->id)->delete();
                };
                Category::where('id', $id)->delete();
            }
        session()->flash('success','Xóa thể loại thành công');
            return response()->json([
                'result' => 'success'
            ]);
        } else {
        session()->flash('fail','Xóa thể loại thất bại, vui lòng kiểm tra lại mật khẩu');
            return response()->json([
                'result' => 'failed'
            ]);
        }
    }
    public function delete(Request $request,$id){
        if( $request->ajax()){
            $password = $request->input('confirmPassword');
            if (Hash::check($password, Auth::guard('admin')->user()->password)){
                $products = Category::findOrFail($id)->products()->get();
                foreach ($products as $product){
                    $types = Product::findOrFail($product->id)->types()->get();
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
                    Product::where('id', $product->id)->delete();
                };
                Category::where('id', $id)->delete();
                session()->flash('success','Xóa thể loại thành công');
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                session()->flash('fail','Xóa thể loại thất bại, vui lòng kiểm tra lại mật khẩu');
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
            $result = Category::where('id', $id)->update([
                        'name' => $name,
                        'desc' => $desc,
                        'updated_at' => now()
                    ]);
            if ($result){
                session()->flash('success','Cập nhật thể loại thành công');
                return response()->json([
                    'result' => 'success',
                ]);
            }
        }
    }
    public function create(Request $request){
        $name = $request->input('name');
        $desc = $request->input('desc');
        Category::insert([
            'name' => $name,
            'desc' => $desc,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        session()->flash('success','Thêm thể loại thành công');
        return back();
    }
}
