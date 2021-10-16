<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile(){
        $select = 'Profile';
        $active = 'profile';
        $admin = Auth::guard('admin')->user();
        $image = Storage::disk('admin-avatar')->url($admin->avatar == null ? 'unknown.png' : $admin->avatar);
        return view('backend.main.profile',compact(['select','admin','active','image']));
    }
    
    public function changePassword(Request $request){
        if( $request->ajax()){
            $oldPassword = $request->input('oldPassword');
            $password = $request->input('password');
            if (Hash::check($oldPassword, Auth::guard('admin')->user()->password)){
                Admin::where('id', Auth::guard('admin')->user()->id)->update([
                    'password' => Hash::make($password)
                ]);
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                return response()->json([
                    'result' => 'failed'
                ]);
            }
        }
    }
}
