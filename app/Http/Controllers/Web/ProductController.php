<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function productView(Request $request,$category_id,$product_id){
        
       
        $category_info = Category::where('id',$category_id)->first();
        $product = Product::where('id',$product_id)->first();
        $latest_types = Product::findOrFail($product->id)->types()->latest()->take(3)->get();
        $breadCrumbs = [
            [
                'name' => $category_info->name,
                'link' => '/categories/'.$category_id,
            ],
            [
                'name' => $product->name,
                'link' => '/categories/'.$category_id.'/products/'.$product->id,
            ]
        ];
        $active = 'categories';
        $paginate = 9;
        $sort_by_price = 'none';
        $search = '';
        $price = 'none';
        if ($request->has('paginate')){
            $paginate = $request->input('paginate');
        }
        $types = Product::findOrFail($product_id)
        ->types()
        ->when( request ('search', false) ,function($query,$search){
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->when( request ('price', false) ,function($query,$price){
            return $query->orderBy('price', $price);
        })
        ->paginate($paginate);
        if ($request->has('price')){
            $sort_by_price = $request->input('price');
            $types->appends(['price'=> $request->input('price')]);
        }
        if ($request->has('search')){
            $search = $request->input('search');
            $types->appends(['search'=> $request->input('search')]);
        }
        if ($request->has('paginate')){
            $types->appends(['paginate'=> $request->input('paginate')]);
        }
        return view('frontend.product',compact(['breadCrumbs','types','category_info','latest_types','sort_by_price','search','paginate','active']));
    }
    public function quickShop(Request $request){
        if( $request->ajax()){
            $id = $request->input('id');
            $type = Type::where('id',$id)->first();
            // return response()->json(['name'=>'ahihi']);
            return json_encode($type);
        }
    }
    public function getImages(Request $request){
        if( $request->ajax()){
            $type_id = $request->input('id');
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
    public function getUrl($product_id){
        $product= Type::where('id',$product_id)->first();
        $category_id= Product::where('id',$product_id)->first()->category_id;
        $link = url('categories/'.$category_id.'/products/'.$product_id);
        return redirect($link);
    }

}
