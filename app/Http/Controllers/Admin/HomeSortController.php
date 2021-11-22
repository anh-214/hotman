<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homesort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeSortController extends Controller
{   
    public function homeSort(){
        $select = 'Bố cục trang chủ';
        $active = 'homesort';
        $homesorts = collect();
        $homesorts->headers =  Homesort::where('role','header')->orderBy('position','asc')->get();
        $homesorts->sections =  Homesort::where('role','section')->orderBy('position','asc')->get();
        $homesorts->footers =  Homesort::where('role','footer')->orderBy('position','asc')->get();
        return view('backend.homesort.homeSort',compact('select','active','homesorts'));
    }
    public function showHomeSortCreate(){
        $select = 'Thêm thành phần trang chủ';
        $active = 'homesort';
        return view('backend.homesort.homeSortCreate',compact('select','active'));
    }
    public function homeSortCreate(Request $request){
        $latest = Homesort::where('role',$request->input('role'))->orderBy('position','desc')->first();
        if ($latest == null){
            Homesort::insert([
                'role' => $request->input('role'),
                'position' => 1,
                'content' => $request->input('content'),
                'description' => $request->input('description'),
                'show' => $request->input('show'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            Homesort::insert([
                'role' => $request->input('role'),
                'position' => $latest->position+1,
                'content' => $request->input('content'),
                'description' => $request->input('description'),
                'show' => $request->input('show'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        session()->flash('success','Thêm thành phần thành công');
        return redirect('admin/homesorts');
    }
    public function fileManager(){
        $select = 'Quản lí file';
        $active = 'filemanager';
        return view('backend.main.fileManager',compact('select','active'));
    }
    public function up($id){
        $down = Homesort::where('id',$id)->first();
        if ($down->position != '1'){
            $up = Homesort::where('role',$down->role)->where('position',$down->position-1)->first();
            if ($up != null){
                Homesort::where('id',$up->id)->update([
                    'position' => $down->position
                ]);
                Homesort::where('id',$down->id)->update([
                    'position' => $down->position-1
                ]);
                session()->flash('success','Di chuyển thành phần thành công');
                return back();
            } else {
                Homesort::where('id',$down->id)->update([
                    'position' => $down->position-1
                ]);
                return back();
            }
        } else {
            return back();
        }
    }
    public function down($id){
        $up = Homesort::where('id',$id)->first();
        if ($up->position != Homesort::where('role',$up->role)->orderBy('position','desc')->first()->position){
            $down = Homesort::where('role',$up->role)->where('position',$up->position+1)->first();
            Homesort::where('id',$down->id)->update([
                'position' => $up->position
            ]);
            Homesort::where('id',$up->id)->update([
                'position' => $up->position+1
            ]);
            session()->flash('success','Di chuyển thành phần thành công');
            return back();
        } else {
            return back();
        }
    }
    public function delete(Request $request){
        $id = $request->input('id');
        $password = $request->input('password');
        if (Hash::check($password, Auth::guard('admin')->user()->password)){
            $current = Homesort::where('id',$id)->first();
            $changes = Homesort::where('role',$current->role)->where('position','>',$current->position)->get();
            Homesort::where('id',$id)->delete();
            foreach ($changes as $change){
                Homesort::where('id',$change->id)->update([
                    'position' => $change->position-1
                ]);
            }
            session()->flash('success','Xóa thành phần thành công');
            return response()->json([
                'result' => 'success'
            ]);
        } else {
            session()->flash('fail','Xóa thành phần thất bại, vui lòng kiểm tra lại mật khẩu');
            return response()->json([
                'result' => 'failed'
            ]);
        }
    }
    public function showHomeSortUpdate($id){
        $homesort = Homesort::where('id',$id)->first();
        $select = 'Cập nhật thành phần trang chủ';
        $active = 'homesort';
        return view('backend.homesort.homeSortUpdate',compact('select','active','homesort'));
    }
    public function homeSortUpdate(Request $request,$id){
        $request->validate([
            'role' => 'required',
            'content' => 'required',
            'description' => 'required',
            'show' => 'required'
        ]);
        Homesort::where('id',$id)->update([
            'role' => $request->input('role'),
            // 'position' => $position,
            'content' => $request->input('content'),
            'description' => $request->input('description'),
            'show' => $request->input('show'),
            'updated_at' => now()
        ]);
        session()->flash('success','Cập nhật thành phần thành công');
        return redirect('admin/homesorts');
    }
}
