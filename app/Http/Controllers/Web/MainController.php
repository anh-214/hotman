<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Type;
use ArrayObject;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{   
    public function home(){
        if (Auth::guard('web')->check()){
            die(Auth::guard('web')->user()->name);
        }
    }
    public function contactView(){
        $breadCrumbs = [
            [
                'name' => 'Contact',
                'link' => '/contact',
            ]
        ];
        return view('frontend.contact',compact('breadCrumbs'));
    }
}
