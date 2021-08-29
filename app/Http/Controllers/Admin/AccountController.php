<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;
class AccountController extends Controller
{
    public function index(){
        $select = 'manager';
        $admins = DB::table('admins')->get();
        return view('backend.dashboard.manager',compact(['select','admins']));
    }
    public function delete(Request $request){
        if( $request->ajax()){
            $id = $request->input('deleteId');
            $password = $request->input('confirmPassword');
            if (Hash::check($password, Auth::guard('admin')->user()->password)){
                DB::table('admins')->where('id', $id)->delete();
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
    public function update(Request $request){
        if( $request->ajax()){
            $name = $request->input('name');
            $id = $request->input('id');
            DB::table('admins')->where('id', $id)->update([
                'name' => $name,
            ]);
            if ($file = $request->input('upload')){
                $image_parts = explode(";base64,", $file);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = $id.'.png';
                Storage::disk('admin-avatar')->put($imageName, $image_base64);
                DB::table('admins')->where('id',$id)->update([
                    'avatar' => $imageName
                ]);
            };
            return response()->json([
                'success' => 'done',
            ]);
        }
        // resize and crop avatar

        // dd($image);
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:8'
        ]);
        Admin::create($request->input());

        DB::table('admins')->where('email',$request->input('email'))->update([
                'email_verified_at' => now(),
                'remember_token' => Str::random(60),
        ]);
    
        return response()->json([
            'result' => 'success',
        ]);   
    }
    public function checkEmailExists(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'unique:admins,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result' => 'exists',
            ]);
        } else {
            return response()->json([
                'result' => 'notExists',
            ]);
        }
    }
    public function profile(){
        $select = 'profile';
        $admin = Auth::guard('admin')->user();
        return view('backend.dashboard.profile',compact(['select','admin']));
    }
    public function updateProfile(Request $request){
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
