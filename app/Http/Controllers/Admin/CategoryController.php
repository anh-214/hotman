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
    public function delete(Request $request){
        if( $request->ajax()){
            $password = $request->input('confirmPassword');
            if ($request->has('mutipleId')){
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
            
            $result = Category::where('id', $id)->update([
                        'name' => $name,
                        'desc' => $desc,
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
        // resize and crop avatar

        // dd($image);
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
        return back();
    }
}
