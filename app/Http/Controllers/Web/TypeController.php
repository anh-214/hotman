<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class TypeController extends Controller
{
    public function typeView($category_id,$product_id,$type_id){

        $category_info = Category::where('id',$category_id)->first();
        $product_info = Product::where('id',$product_id)->first();
        $type_info = Type::where('id',$type_id)->with('images')->first();
        
        // dd($type_info->sizes);
        $breadCrumbs = [
            [
                'name' => $category_info->name,
                // 'link' => '/category/'.$category_id,
                'link' => '#'
            ],
            [
                'name' => $product_info->name,
                'link' => '/category/'.$category_id.'/product/'.$product_info->id,
            ],
            [
                'name' => $type_info->name,
                'link' => '/category/'.$category_id.'/product/'.$product_info->id.'/type/'.$type_info->id,
            ]
        ];
        // $images = \App\Models\Type::findOrFail($type_info->id)->images()->get();
        // dd($images);
        return view('frontend.type',compact(['breadCrumbs','type_info','category_info','product_info']));
    }
    public function getTypeInfo(Request $request){
        if ($request->ajax()){
            $id = $request->input('id');
            $type = Type::where('id',$id)->first();
            $type_image = Type::findOrFail($id)->images->first()->name;
            $product_id_cart = \App\Models\Type::where('id',$type->id)->first()->product_id;
            $category_id_cart = \App\Models\Product::where('id',$product_id_cart)->first()->category_id;
            $type['image'] = $type_image;
            $type['link'] = url('category/'.$category_id_cart.'/product/'.$product_id_cart.'/type/'.$type->id);
            // return response()->json(['name'=>'ahihi']);
            return json_encode($type);
        }
    }
    public function getUrl($type_id){
        $type = Type::where('id',$type_id)->first();
        $product_id= Type::where('id',$type->id)->first()->product_id;
        $category_id= Product::where('id',$product_id)->first()->category_id;
        $link = url('category/'.$category_id.'/product/'.$product_id.'/type/'.$type->id);
        return redirect($link);
    }
}
