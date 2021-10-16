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
        $headers = Homesort::where('role','header')->orderBy('position','asc')->get();
        $position1 = Promotion::where('id','3')->with('types')->first();
        foreach ($position1->types as $type){
            $image = Image::where('type_id',$type->id)->first()->name;

            if (filter_var($image, FILTER_VALIDATE_URL)) { 
                $type->image = $image;
            } else {
                $type->image = Storage::disk('type-image')->url($image);
            }   
        }
        return view('frontend.home',compact('active','position1','headers'));
    }
    public function contactView(){
        $active = 'contact';
        $breadCrumbs = [
            [
                'name' => 'Contact',
                'link' => '/contact',
            ]
        ];
        return view('frontend.contact',compact('breadCrumbs','active'));
    }
}
