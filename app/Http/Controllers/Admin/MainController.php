<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function dashboard(){
        $select = 'Dashboard';
        $active = 'dashboard';
        return view('backend.main.dashboard',compact('select','active'));
    }
    public function manager(){
        $select = 'Manager';
        $active = 'manager';
        $admins = Admin::all();
        return view('backend.main.manager',compact(['select','admins','active']));
    }
    public function profile(){
        $select = 'Profile';
        $active = 'profile';
        $admin = Auth::guard('admin')->user();
        return view('backend.main.profile',compact(['select','admin','active']));
    }
    public function categories(Request $request){
        $select = 'Categories';
        $active = 'categories';

        if ($request->has('id')) {
            $category = Category::where('id',$request->input('id'))->first();
            return view('backend.main.category',compact('select','active','category'));
        }

        $categories = Category::paginate(15);
        return view('backend.main.category',compact(['select','active','categories']));
    }
    public function products(Request $request){
        $select = 'Products';
        $active = 'products';

        if ($request->has('id')) {
            $product = Product::where('id',$request->input('id'))->first();
            $category = Category::where('id',$product->category_id)->first();
            $categories = Category::all();
            return view('backend.main.product',compact('select','active','product','categories','category'));
        }

        $categories = Category::all(['id','name']); 
        if ($request->has(['category_id'])){
            $products = Category::findOrFail($request->input('category_id'))->products()->paginate(15);
            $products->appends(['category_id'=> $request->input('category_id')]);
            return view('backend.main.product',compact('select','active','products','categories'));
        };
        $products = Product::with('category')->paginate(15);
        return view('backend.main.product',compact('select','active','products','categories'));
    }
    
    public function types(Request $request){
        $select = 'Types';
        $active = 'types';

        if ($request->has(['product_id'])){
            $types = Product::findOrFail($request->input('product_id'))->types()->paginate(15);
            $types->appends(['product_id'=> $request->input('product_id')]);
            return view('backend.main.type',compact('select','active','types'));
        };
        $types = Type::paginate(15);
        return view('backend.main.type',compact('select','active','types'));
    }
    public function images(){
        $select = 'Images';
        $active = 'images';
        return view('backend.main.image',compact('select','active'));
    }
}
