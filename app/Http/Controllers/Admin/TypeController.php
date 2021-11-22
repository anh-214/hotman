<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TypesImport;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\type;

class TypeController extends Controller
{
    public function types(Request $request){
        $select = 'Quản lí loại sản phẩm';
        $active = 'types';
        $search = '';
        $types = Type::with('promotion')->paginate(15);

        if ($request->has(['product_id'])){
            $types = Product::findOrFail($request->input('product_id'))->types()->paginate(15);
            $types->appends(['product_id'=> $request->input('product_id')]);
        };
        if ($request->has('search')){
            $search = $request->input('search');
            $types = Type::where('name', 'LIKE', '%' . $request->input('search') . '%')->paginate(15);
            $types->appends(['search'=> $request->input('search')]);
        }
        
        return view('backend.type.type',compact('select','active','types','search'));
    }
    public function typeInfo($id){
        $type = Type::where('id',$id)->with('images')->first();
        $select = 'Chi tiết loại sản phẩm';
        $active = 'types';
        return view('backend.type.typeInfo',compact('select','active','type'));
    }

    
    public function showUpdateForm($id){
        $active = 'Cập nhật loại sản phẩm';
        $select = 'Update type';
        $type = Type::where('id',$id)->with('product')->first();
        $type->allProducts = Category::findOrFail($type->product->category_id)->products()->get();
        $promotions = Promotion::all();
        $categories = Category::all('id','name');
        return view('backend.type.updateForm',compact('active','select','categories','type','promotions'));
    }
    public function update(Request $request,$id){
        // optimal data colors
        // dd($request);
        $color = $request->input('colorType');
        // optimal data sizes
        $sizes = $request->input('sizesType');
        $sizes = explode(",",$sizes);
        for ($i=0; $i<count($sizes);$i++){
            $sizes[$i] = trim($sizes[$i]," ");
        }
        $sizes = implode(",",$sizes);
        $promotion_id = $request->input('promotion_id');
        $initial_price = $request->input('initialPriceType');
        if ($promotion_id == 'none'){
            $promotion_id = null;
            $price = $initial_price;
        } else {
            $price = $initial_price - ($initial_price * (intval(Promotion::where('id',$promotion_id)->first()->discount)/100));
        };
        Type::where('id',$id)->update([
            'name' => $request->input('nameType'),
            'price' => $price,
            'initial_price' => $initial_price,
            'sizes' => $sizes,
            'color' => $color,
            'designs' => $request->input('designsType'),
            'details' => $request->input('detailsType'),
            'material' => $request->input('materialType'),
            'product_id' => $request->input('product_id'),
            'promotion_id' => $promotion_id,
            'updated_at' => now()
        ]);
        
        $files = $request->file('images');
        // dd($files);
        if ($files != null){
            Type::findOrFail($id)->images()->delete();
            $count = 0;
            foreach ($files as $file){
                $file->storeAs('',$id.'-'.$count.'.'.$file->getClientOriginalExtension(),'type-image');
                Image::insert([
                    'name'=> $id.'-'.$count.'.'.$file->getClientOriginalExtension(),
                    'color' => $color,
                    'type_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $count += 1;
            }
        }
        // add link
        $links = $request->input('linkImages');
        if ($links != null){
            if ($files == null){
                Type::findOrFail($id)->images()->delete();
            }
            $links = explode(",",$links);
            foreach ($links as $link){
                if (filter_var($link, FILTER_VALIDATE_URL)) {    
                    Image::insert([
                        'name'=> $link,
                        'color' => $color,
                        'type_id' => $id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                };
            }
        }
        session()->flash('success','Cập nhật loại sản phẩm thành công');
        return redirect('admin/types');
    }
    public function showCreateForm(){
        // dd('ahihi');
        $active = 'Tạo loại sản phẩm';
        $select = 'Create type';
        $categories = Category::all('id','name');
        $promotions = Promotion::all();
        return view('backend.type.createForm',compact('active','select','categories','promotions'));
    }
    public function create(Request $request){
        // dd($request->file('images'));
        $color = $request->input('colorType');
        // optimal data sizes
        $sizes = $request->input('sizesType');
        $sizes = explode(",",$sizes);
        for ($i=0; $i<count($sizes);$i++){
            $sizes[$i] = trim($sizes[$i]," ");
        }
        $sizes = implode(",",$sizes);
        $promotion_id = $request->input('promotion_id');
        $initial_price = $request->input('initialPriceType');
        if ($promotion_id == 'none'){
            $promotion_id = null;
            $price = $initial_price;
        } else {
            $price = $initial_price - ($initial_price * (intval(Promotion::where('id',$promotion_id)->first()->discount)/100));
        };
        $result =  Type::create([
                'name' => $request->input('nameType'),
                'price' => $price,
                'initial_price' => $initial_price,
                'sizes' => $sizes,
                'color' => $color,
                'designs' => $request->input('designsType'),
                'details' => $request->input('detailsType'),
                'material' => $request->input('materialType'),
                'product_id' => $request->input('product_id'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        
        $files = $request->file('images');
        if ($files != null){
            $count = 0;
            foreach ($files as $file){
                $file->storeAs('',$result->id.'-'.$count.'.'.$file->getClientOriginalExtension(),'type-image');
                Image::insert([
                    'name'=> $result->id.'-'.$count.'.'.$file->getClientOriginalExtension(),
                    'color' => $color,
                    'type_id' => $result->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $count += 1;
            }
        }
        // add link
        $links = $request->input('linkImages');
        if ($links != null){
            $links = explode(",",$links);
            foreach ($links as $link){
                if (filter_var($link, FILTER_VALIDATE_URL)) {    
                    Image::insert([
                        'name'=> $link,
                        'color' => $color,
                        'type_id' => $result->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                };
            }
        }
        session()->flash('success','Tạo loại sản phẩm thành công');
        return redirect('admin/types');
    }
    public function getProductId(Request $request){
        if( $request->ajax()){
            $category_id = $request->input('category_id');
            $products = Category::findOrFail($category_id)->products()->get();
            return json_encode($products);
        }
    }
    public function mutipleDelete(Request $request){
        if ($request->ajax()){
            $password = $request->input('confirmPassword');
            if ($request->has('mutipleId')){
                if (Hash::check($password, Auth::guard('admin')->user()->password)){
                    $ids = $request->input('mutipleId');
                    foreach ($ids as $id){
                        $files = Type::findOrFail($id)->images()->get();
                        Type::findOrFail($id)->images()->delete();
                        foreach ($files as $file){
                            if (!filter_var($file->name, FILTER_VALIDATE_URL)){
                                Storage::disk('type-image')->delete($file->name);
                            }
                        }
                        Type::where('id',$id)->delete();
                    }
                    session()->flash('success','Xóa loại sản phẩm thành công');
                    return response()->json([
                        'result' => 'success'
                    ]);
                } else {
                    session()->flash('fail','Xóa loại sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu');
                    return response()->json([
                        'result' => 'failed'
                    ]);
                }
            }

        }
    }
    public function delete(Request $request,$id){
        if( $request->ajax()){
            $password = $request->input('confirmPassword');
            if (Hash::check($password, Auth::guard('admin')->user()->password)){
                $files = Type::findOrFail($id)->images()->get();
                Type::findOrFail($id)->images()->delete();
                foreach ($files as $file){
                    if (!filter_var($file->name, FILTER_VALIDATE_URL)){
                        Storage::disk('type-image')->delete($file->name);
                    }
                }
                Type::where('id',$id)->delete();
                session()->flash('success','Xóa loại sản phẩm thành công');
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                session()->flash('fail','Xóa loại sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu');
                return response()->json([
                    'result' => 'failed'
                ]);
            }
            
        }
    }
    public function getImages(Request $request){
        if( $request->ajax()){
            $type_id = $request->input('type_id');
            $links = array();
            $images =Type::findOrFail($type_id)->images()->get();
            foreach ($images as $image){
                if (filter_var($image->name, FILTER_VALIDATE_URL)) { 
                    array_push($links,$image->name);
                } else {
                    $link = Storage::disk('type-image')->url($image->name);
                    array_push($links,$link);
                }   
            }
            return json_encode($links);
        }
    }
    public function showImportCsvForm(){
        return view('backend.type.importCsv');
    }
    public function importCsv(Request $request){
        Excel::import(new TypesImport, $request->file('csvfile'));
        return back();
    }
    
}
