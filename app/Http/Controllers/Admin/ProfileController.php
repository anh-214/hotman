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
        $select = 'Hồ sơ của tôi';
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
                session()->flash('success','Đổi mật khẩu thành công');
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                session()->flash('success','Đổi mật khẩu thất bại, vui lòng kiểm tra lại mật khẩu');
                return response()->json([
                    'result' => 'failed'
                ]);
            }
        }
    }
    public function update(Request $request){
        if( $request->ajax()){
            $request->validate([
                'name' => 'required',
                'id' => 'required',
            ]);
            $name = $request->input('name');
            $id = $request->input('id');
            $role = $request->input('role');
            if ($file = $request->input('upload')){
                $image_parts = explode(";base64,", $file);
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = $id.'.png';
                Storage::disk('admin-avatar')->delete($imageName);
                Storage::disk('admin-avatar')->put($imageName, $image_base64);
                Admin::where('id',$id)->update([
                    'avatar' => $imageName,
                    'name' => $name,
                    'updated_at' => now()
                ]);
            } else {
                Admin::findOrFail($id)->update([
                    'name' => $name,
                    'updated_at' => now()
                ]);
            };
            session()->flash('success', 'Cập nhật tài khoản thành công');
            return response()->json([
                'success' => 'done',
            ]);
        }
    }
}
