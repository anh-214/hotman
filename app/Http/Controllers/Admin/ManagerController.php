<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    public function managerAdmins(){
        $select = 'Quản lí tài khoản Admin';
        $active = 'admins';
        $admins = Admin::paginate(15);
        return view('backend.main.managerAdmin',compact(['select','admins','active']));
    }
    public function update(Request $request){
        if( $request->ajax()){
            $request->validate([
                'name' => 'required',
                'id' => 'required',
                'role' => 'required'
            ]);
            $name = $request->input('name');
            $id = $request->input('id');
            $role = $request->input('role');
            if ($file = $request->input('upload')){
                $image_parts = explode(";base64,", $file);
                $image_type_aux = explode("image/", $image_parts[0]);
                // $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = $id.'.png';
                Storage::disk('admin-avatar')->delete($imageName);
                Storage::disk('admin-avatar')->put($imageName, $image_base64);
                Admin::where('id',$id)->update([
                    'avatar' => $imageName,
                    'name' => $name,
                    'role' => $role,
                    'updated_at' => now()
                ]);
            } else {
                Admin::findOrFail($id)->update([
                    'name' => $name,
                    'role' => $role,
                    'updated_at' => now()
                ]);
            };
            session()->flash('success', 'Cập nhật tài khoản thành công');
            return response()->json([
                'success' => 'done',
            ]);
        }
    }
    public function delete(Request $request){
        $request->validate([
            'deleteId' => 'required',
            'confirmPasswordDelete' => 'required'
        ]);
        $id = $request->input('deleteId');
        $password = $request->input('confirmPasswordDelete');
        if (Hash::check($password, Auth::guard('admin')->user()->password)){
            Admin::where('id', $id)->delete();
            Storage::disk('admin-avatar')->delete($id.'.png');
            session()->flash('success', 'Xóa tài khoản thành công');
            return back();
        } else {
            session()->flash('fail', 'Xóa tài khoản thất bại, vui lòng kiểm tra lại mật khẩu');
            return back();
        }
            
    }
    
    public function create(Request $request){
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);
        // dd('ahihi');
        Admin::create($request->input());
        Admin::where('email',$request->input('email'))->update([
                'email_verified_at' => now(),
                'remember_token' => Str::random(60),
        ]);
        session()->flash('success', 'Tạo tài khoản thành công');
        return back();
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
    public function managerUsers(){
        $select = 'Quản lí tài khoản User';
        $active = 'users';
        $users = User::paginate(15);
        return view('backend.main.managerUser',compact(['select','users','active']));
    }
    public function deleteUser(Request $request,$id){
        $request->validate([
            'confirmPassword' => 'required'
        ]);
        $password = $request->input('confirmPassword');
        if (Hash::check($password, Auth::guard('admin')->user()->password)){
            User::findOrFail($id)->orders()->delete();
            User::where('id', $id)->delete();
            Storage::disk('user-avatar')->delete($id.'.png');
            session()->flash('success', 'Xóa tài khoản thành công');
            return response()->json([
                'result' => 'success',
            ]);
        } else {
            session()->flash('fail', 'Xóa tài khoản thất bại, vui lòng kiểm tra lại mật khẩu');
            return response()->json([
                'result' => 'faild',
            ]);
        }
    }
    
}
