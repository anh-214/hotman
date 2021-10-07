<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function productView(Request $request,$category_id,$product_id){
        $category_info = Category::findOrFail($category_id)->first();
        $product_infos = Category::findOrFail($category_id)->products()->get(['id','name']);
        $product = Product::where('id',$product_id)->first();
        if ($request->has(['paginate','price'])){
            $paginate = $request->input('paginate') < 9 ? 9 : $request->input('paginate');
            if ($request->input('price') == 'up'){  
                $sort_by_price = 'up';
                $types = Product::findOrFail($category_id)->types()->orderBy('price', 'asc')->paginate($paginate);
                $types->appends(['paginate'=> $paginate,'price'=> $sort_by_price]);
                // dd($types);
            } else {
                $sort_by_price = 'down';
                $types = Product::findOrFail($category_id)->types()->orderBy('price', 'desc')->paginate($paginate);
                $types->appends(['paginate'=> $paginate,'price'=> $sort_by_price]);
            }
        } elseif ($request->has('paginate')){
            $paginate = $request->input('paginate') < 9 ? 9 : $request->input('paginate');
            $sort_by_price = 'none';
            $types = Product::findOrFail($category_id)->types()->paginate($paginate);
            $types->appends(['paginate'=> $paginate]);
        } elseif ($request->has('price')){
            $paginate = 9;
            if ($request->input('price') == 'up'){  
                $sort_by_price = 'up';
                $types = Product::findOrFail($category_id)->types()->orderBy('price', 'asc')->paginate($paginate);
                $types->appends(['price'=> $sort_by_price]);
                // dd($types);
            } else {
                $sort_by_price = 'down';
                $types = Product::findOrFail($category_id)->types()->orderBy('price', 'desc')->paginate($paginate);
                $types->appends(['price'=> $sort_by_price]);
            }
        } else {
            $sort_by_price = 'none';
            $paginate = 9;
            $types = Product::findOrFail($category_id)->types()->paginate(9);
        }
        $latest_types = Product::findOrFail($product->id)->types()->with('images')->latest()->take(3)->get();
        $breadCrumbs = [
            [
                'name' => $category_info->name,
                'link' => '/category/'.$category_id,
                // 'link' => '#'
            ],
            [
                'name' => $product->name,
                'link' => '/category/'.$category_id.'/product/'.$product->id,
            ]
        ];
        return view('frontend.product',compact(['breadCrumbs','types','category_info','product_infos','latest_types','paginate','sort_by_price']));
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

}
