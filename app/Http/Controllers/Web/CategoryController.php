<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use ArrayObject;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryView(Request $request,$category_id){
        $category_info = Category::where('id',$category_id)->first();
        $search = '';
        $active = 'categories';
        $sort_by_price = 'none';
        $price = 'none';
        $paginate = 9;
        $breadCrumbs = [
            [
                'name' => $category_info->name,
                'link' => '/categories/'.$category_id,
            ],
        ];
        if ($request->has('paginate')){
            $paginate = $request->input('paginate');
        }
        $types = Category::findOrFail($category_id)
        ->types()
        ->when( request ('search', false) ,function($query,$search){
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->when( request ('price', false) ,function($query,$price){
            return $query->orderBy('price', $price);
        })->paginate($paginate);
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
        return view('frontend.category',compact(['breadCrumbs','types','category_info','sort_by_price','search','paginate','active']));
    }
}
