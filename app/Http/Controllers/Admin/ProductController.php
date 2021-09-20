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
        return back();
    }
    public function delete(Request $request){
        if( $request->ajax()){
            $password = $request->input('confirmPassword');
            if ($request->has('mutipleId')){
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
                    return response()->json([
                        'result' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'result' => 'failed'
                    ]);
                }
            }

            $id = $request->input('deleteId');
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
                    return response()->json([
                        'result' => 'success'
                    ]);
            } else {
                return response()->json([
                    'result' => 'failed'
                ]);
            }
            
        }
    }
    public function update(Request $request){
        if( $request->ajax()){
            $name = $request->input('name');
            $id = $request->input('id');
            $desc = $request->input('desc');
            $category_id = $request->input('category_id');
            $result = Product::where('id', $id)->update([
                        'name' => $name,
                        'desc' => $desc,
                        'category_id' => $category_id,
                        'updated_at' => now()
                    ]);
            if ($result){
                return response()->json([
                    'result' => 'success',
                ]);

            } else {
                return response()->json([
                    'result' => 'failed',
                ]);
            }
        }
    }
}
