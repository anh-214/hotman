<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function showInformation(){
        $breadCrumbs = [
            [
                'name' => 'User',
                'link' => '/user',
            ],
            [
                'name' => 'Information',
                'link' => '/user/information',
            ]
        ];
        $user = Auth::guard('web')->user();
        return view('frontend.account.information',compact(['user','breadCrumbs']));
    }
    public function updateInformation(Request $request){
        if( $request->ajax()){
            $id = Auth::guard('web')->user()->id;
            if ($file = $request->input('upload')){
                $image_parts = explode(";base64,", $file);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = $id.'.png';
                Storage::disk('user-avatar')->delete($imageName);
                Storage::disk('user-avatar')->put($imageName, $image_base64);
                User::where('id',$id)->update([
                    'avatar' => $imageName,
                    'updated_at' => now()
                ]);
                return response()->json([
                    'result' => 'success',
                ]);
            }
        };
        if ($request->has(['name', 'phonenumber'])) {
            $name = $request->input('name');
            $phonenumber = $request->input('phonenumber');
            User::where('id',Auth::guard('web')->user()->id)->update([
                'name' => $name,
                'phonenumber' => $phonenumber,
                'updated_at' => now()
            ]);
            return back();
        }
    }
}
