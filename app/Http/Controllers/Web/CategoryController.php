<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use ArrayObject;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryView(Request $request,$category_id){
        $category_info = Category::where('id',$category_id)->first();
        $product_infos = Category::findOrFail($category_id)->products()->get(['id','name']);
        if ($request->has(['paginate','price'])){
            $paginate = $request->input('paginate') < 9 ? 9 : $request->input('paginate');
            if ($request->input('price') == 'up'){  
                $sort_by_price = 'up';
                $types = Category::findOrFail($category_id)->types()->orderBy('price', 'asc')->paginate($paginate);
                $types->appends(['paginate'=> $paginate,'price'=> $sort_by_price]);
            } else {
                $sort_by_price = 'down';
                $types = Category::findOrFail($category_id)->types()->orderBy('price', 'desc')->paginate($paginate);
                $types->appends(['paginate'=> $paginate,'price'=> $sort_by_price]);
            }
        } elseif ($request->has('paginate')){
            $paginate = $request->input('paginate') < 9 ? 9 : $request->input('paginate');
            $sort_by_price = 'none';
            $types = Category::findOrFail($category_id)->types()->paginate($paginate);
            $types->appends(['paginate'=> $paginate]);
        } elseif ($request->has('price')){
            $paginate = 9;
            if ($request->input('price') == 'up'){  
                $sort_by_price = 'up';
                $types = Category::findOrFail($category_id)->types()->orderBy('price', 'asc')->paginate($paginate);
                $types->appends(['price'=> $sort_by_price]);
                // dd($types);
            } else {
                $sort_by_price = 'down';
                $types = Category::findOrFail($category_id)->types()->orderBy('price', 'desc')->paginate($paginate);
                $types->appends(['price'=> $sort_by_price]);
            }
        } else {
        $sort_by_price = 'none';
        $paginate = 9;
        $types = Category::findOrFail($category_id)->types()->paginate(9);

        }
        
        // dd($types);
        $breadCrumbs = [
            [
                'name' => $category_info->name,
                'link' => '/category/'.$category_id,
                // 'link' => '#'
            ],
        ];
        return view('frontend.product',compact(['breadCrumbs','types','category_info','product_infos','paginate','sort_by_price']));
    }
}
