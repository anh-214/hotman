<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TypesImport;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\type;

class TypeController extends Controller
{
    public function showCreateForm(){
        $active = 'types';
        $select = 'Create type';
        $categories = Category::all('id','name');
        return view('backend.type.createForm',compact('active','select','categories'));
    }
    public function showUpdateForm(Request $request){
        $active = 'types';
        $select = 'Update type';
        $id = $request->input('id');
        $type = Type::where('id',$id)->first();

        $oldProductId = $type->product_id;
       
        $product = Product::where('id',$oldProductId)->first();
        $oldCategoryId = $product->category_id;

        $oldProducts = Category::findOrFail($oldCategoryId)->products()->get();
        $categories = Category::all('id','name');
        return view('backend.type.updateForm',compact('active','select','categories','type','oldCategoryId','oldProductId','oldProducts'));
    }
    public function getProductId(Request $request){
        if( $request->ajax()){
            $category_id = $request->input('category_id');
            $products = Category::findOrFail($category_id)->products()->get();
            return json_encode($products);
        }
    }
    public function create(Request $request){
        // optimal data colors
        $colors = $request->input('colorsType');
        $colors = explode(",",$colors);
        for ($i=0; $i<count($colors);$i++){
            $colors[$i] = trim($colors[$i]," ");
        }
        $colors = implode(",",$colors);
        // optimal data sizes
        $sizes = $request->input('sizesType');
        $sizes = explode(",",$sizes);
        for ($i=0; $i<count($sizes);$i++){
            $sizes[$i] = trim($sizes[$i]," ");
        }
        $sizes = implode(",",$sizes);
       
        $result =  Type::insert([
                'name' => $request->input('nameType'),
                'price' => $request->input('priceType'),
                'initial_price' => $request->input('initialPriceType'),
                'sizes' => $sizes,
                'colors' => $colors,
                'designs' => $request->input('designsType'),
                'details' => $request->input('detailsType'),
                'material' => $request->input('materialType'),
                'product_id' => $request->input('product_id'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        if ($result){
            $type = Type::where('name',$request->input('nameType'))->where('product_id',$request->input('product_id'))->first();
            $colors = $request->input('colorsType');
            $colors = explode(",",$colors);
            for ($i=0; $i<count($colors);$i++){
                $colors[$i] = trim($colors[$i]," ");
            }
            $active = 'types';
            $select = 'Thêm ảnh sản phẩm';
            return view('backend.type.addImage',compact('active','select','colors','type'));
        }
    }
    public function update(Request $request){
        // optimal data colors
        $colors = $request->input('colorsType');
        $colors = explode(",",$colors);
        for ($i=0; $i<count($colors);$i++){
            $colors[$i] = trim($colors[$i]," ");
        }
        $colors = implode(",",$colors);
        // optimal data sizes
        $sizes = $request->input('sizesType');
        $sizes = explode(",",$sizes);
        for ($i=0; $i<count($sizes);$i++){
            $sizes[$i] = trim($sizes[$i]," ");
        }
        $sizes = implode(",",$sizes);
        $type_id = $request->input('id');
        $result =  Type::where('id',$type_id)->update([
                'name' => $request->input('nameType'),
                'price' => $request->input('priceType'),
                'initial_price' => $request->input('initialPriceType'),
                'sizes' => $sizes,
                'colors' => $colors,
                'designs' => $request->input('designsType'),
                'details' => $request->input('detailsType'),
                'material' => $request->input('materialType'),
                'product_id' => $request->input('product_id'),
                'updated_at' => now()
            ]);
        if ($result){
            Type::findOrFail($type_id)->images()->delete();
            $type = Type::where('id',$type_id)->first();
            $colors = $request->input('colorsType');
            $colors = explode(",",$colors);
            for ($i=0; $i<count($colors);$i++){
                $colors[$i] = trim($colors[$i]," ");
            }
            $active = 'types';
            $select = 'Cập nhật ảnh sản phẩm';
            return view('backend.type.addImage',compact('active','select','colors','type'));
        }
    }
    public function upload(Request $request){
        $type_id = $request->input('type_id');
        $colors = Type::findOrFail($type_id)->colors;
        $colors = explode(",",$colors);
        $rqs = array();
        foreach ($colors as $color){
            $color = str_replace(" ","-",$color);
            array_push($rqs,$type_id.'-'.$color);
        }
        // upload image
        foreach ($rqs as $rq){
            $files = $request->file($rq);
            if ($files != null){
                $count = 0;
                foreach ($files as $file){
                    $color = preg_split('/\d+-/',$rq);
                    $file->storeAs('',$rq.'-'.$count.'.'.$file->getClientOriginalExtension(),'type-image');
                    Image::insert([
                        'name'=> $rq.'-'.$count.'.'.$file->getClientOriginalExtension(),
                        'color' => $color[1],
                        'type_id' => $type_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $count += 1;
                }
            }
        }
        // add link
        foreach ($rqs as $rq){
            $links = $request->input('link-'.$rq);
            if ($links != null){
                $links = explode(",",$links);
                foreach ($links as $link){
                    if (filter_var($link, FILTER_VALIDATE_URL)) {    
                        $color = preg_split('/\d+-/',$rq);
                        Image::insert([
                            'name'=> $link,
                            'color' => $color[1],
                            'type_id' => $type_id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    };
                }
            }
            
        }
        return redirect('admin/types');
    }
    public function delete(Request $request){
        if( $request->ajax()){
            $password = $request->input('confirmPassword');
            if ($request->has('mutipleId')){
                if (Hash::check($password, Auth::guard('admin')->user()->password)){
                    $ids = $request->input('mutipleId');
                    foreach ($ids as $id){
                        $files = Type::findOrFail($id)->images()->get();
                        Type::findOrFail($id)->images()->delete();
                        foreach ($files as $file){
                            if (!filter_var($file->name, FILTER_VALIDATE_URL)){
                                Storage::disk('type-image')->delete($file->name);
                            }
                        }
                        Type::where('id',$id)->delete();
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
                $files = Type::findOrFail($id)->images()->get();
                Type::findOrFail($id)->images()->delete();
                foreach ($files as $file){
                    if (!filter_var($file->name, FILTER_VALIDATE_URL)){
                        Storage::disk('type-image')->delete($file->name);
                    }
                }
                Type::where('id',$id)->delete();
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
    public function getImages(Request $request){
        if( $request->ajax()){
            $type_id = $request->input('type_id');
            $links = array();
            $images =Type::findOrFail($type_id)->images()->get();
            foreach ($images as $image){
                if (filter_var($image->name, FILTER_VALIDATE_URL)) { 
                    array_push($links,$image->name);
                } else {
                    $link = Storage::disk('type-image')->url($image->name);
                    array_push($links,$link);
                }   
            }
            return json_encode($links);
        }
    }
    public function showImportCsvForm(){
        return view('backend.type.importCsv');
    }
    public function importCsv(Request $request){
        Excel::import(new TypesImport, $request->file('csvfile'));
        return back();
    }
    
}
