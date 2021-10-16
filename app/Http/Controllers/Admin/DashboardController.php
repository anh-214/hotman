<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $select = 'Dashboard';
        $active = 'dashboard';
        return view('backend.main.dashboard',compact('select','active'));
    }
}
