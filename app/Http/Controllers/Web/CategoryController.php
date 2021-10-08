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
        $category = Category::find($category_id);
        $product_infos = Category::findOrFail($category_id)->products()->get(['id','name']);

        $paginate = $request->query('paginate') < 9 ? 9 : $request->query('paginate');
        $hasQueryString = false;
        $sort_by_price = $request->query('price') ? $request->query('price') : 'none';

        $types = collect();
        if ($request->query('paginate') !== null) {
            $types = $category->types()->orderBy('price', 'asc');
            $hasQueryString = true;
        }

        if ($request->query('price') !== null) {
            $types = $category->types()->orderBy('price', $request->query('price'));
            $hasQueryString = true;
        }

        if (!$hasQueryString) {
            $types = $category->types();
        }

        $types->paginate($paginate)->appends($request->query());

        dd($types);
        // dd($types);
        $breadCrumbs = [
            [
                'name' => $category->name,
                'link' => '/category/'.$category_id,
                // 'link' => '#'
            ],
        ];
        return view(
            'frontend.product',
            array_merge(compact(['breadCrumbs', 'types', 'category_info', 'product_infos', 'paginate', 'sort_by_price']), [
                'category_info' => $category
            ])
        );
    }
}
