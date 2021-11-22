<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Homesort;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Type;
use ArrayObject;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{   
    public function home(){
        $active = 'home';
        $sections = Homesort::where('role','section')->orderBy('position','asc')->get();
        $promotions = Promotion::where('show','1')->orderBy('position','asc')->with('types')->get();
        foreach ($promotions as $promotion){
            foreach ($promotion->types as $type){
                $image = Image::where('type_id',$type->id)->first()->name;
    
                if (filter_var($image, FILTER_VALIDATE_URL)) { 
                    $type->image = $image;
                } else {
                    $type->image = Storage::disk('type-image')->url($image);
                }   
            }
        }
        
        return view('frontend.home',compact('active','promotions','sections'));
    }
    public function contactView(){
        $active = 'contact';
        $breadCrumbs = [
            [
                'name' => 'Liên hệ',
                'link' => '/contact',
            ]
        ];
        return view('frontend.contact',compact('breadCrumbs','active'));
    }
}
