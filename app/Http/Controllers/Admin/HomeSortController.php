<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homesort;
use Illuminate\Http\Request;

class HomeSortController extends Controller
{   
    public function homeSort(){
        $select = 'Bố cục trang chủ';
        $active = 'homesort';
        $homesorts = collect();
        $homesorts->headers =  Homesort::where('role','header')->orderBy('position','asc')->get();
        $homesorts->sections =  Homesort::where('role','section')->orderBy('position','asc')->get();
        $homesorts->footers =  Homesort::where('role','footer')->orderBy('position','asc')->get();
        return view('backend.main.homeSort',compact('select','active','homesorts'));
    }
    public function showHomeSortCreate(){
        $select = 'Thêm thành phần trang chủ';
        $active = 'homesort';
        return view('backend.main.homeSortCreate',compact('select','active'));
    }
    public function homeSortCreate(Request $request){
        $latest = Homesort::where('role',$request->input('role'))->orderBy('position','desc')->first();
        if ($latest == null){
            Homesort::insert([
                'role' => $request->input('role'),
                'position' => 1,
                'content' => $request->input('content'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            session()->flash('success','Thêm thành phần thành công');
            return redirect('admin/homesorts');
        } else {
            Homesort::insert([
                'role' => $request->input('role'),
                'position' => $latest->position+1,
                'content' => $request->input('content'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            session()->flash('success','Thêm thành phần thành công');
            return redirect('admin/homesorts');
        }
    }
    public function fileManager(){
        $select = 'File Manager';
        $active = 'filemanager';
        return view('backend.main.fileManager',compact('select','active'));
    }
    public function up($id){
        $down = Homesort::where('id',$id)->first();
        if ($down->position != '1'){
            $up = Homesort::where('role',$down->role)->where('position',$down->position-1)->first();
            Homesort::where('id',$up->id)->update([
                'position' => $down->position
            ]);
            Homesort::where('id',$down->id)->update([
                'position' => $down->position-1
            ]);
            session()->flash('success','Di chuyển thành phần thành công');
            return back();
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
    public function delete($id){
        $current = Homesort::where('id',$id)->first();
        $changes = Homesort::where('role',$current->role)->where('position','>',$current->position)->get();
        Homesort::where('id',$id)->delete();
        foreach ($changes as $change){
            Homesort::where('id',$change->id)->update([
                'position' => $change->position-1
            ]);
        }
        session()->flash('success','Xóa thành phần thành công');
        return back();
    }
    public function showHomeSortUpdate($id){
        $homesort = Homesort::where('id',$id)->first();
        $select = 'Cập nhật thành phần trang chủ';
        $active = 'homesort';
        return view('backend.main.homeSortUpdate',compact('select','active','homesort'));
    }
    public function homeSortUpdate(Request $request,$id){
        $request->validate([
            'role' => 'required',
            'content' => 'required'
        ]);
        $latest = Homesort::where('role',$request->input('role'))->orderBy('position','desc')->first();
        if ($latest == null){
            Homesort::where('id',$id)->update([
                'role' => $request->input('role'),
                'position' => 1,
                'content' => $request->input('content'),
                'updated_at' => now()
            ]);
        } else {
            Homesort::where('id',$id)->update([
                'role' => $request->input('role'),
                'position' => $latest->position+1,
                'content' => $request->input('content'),
                'updated_at' => now()
            ]);
        }
        session()->flash('success','Cập nhật thành phần thành công');
        return redirect('admin/homesorts');
    }
}
