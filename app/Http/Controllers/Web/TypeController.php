<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function typeView($category_id,$product_id,$type_id){
        $category_info = Category::findOrFail($category_id)->first();
        $product_info = Product::findOrFail($product_id)->first();
        $type_info = Type::where('id',$type_id)->first();
        
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
}
