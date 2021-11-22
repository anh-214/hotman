<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;

class LiveSearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            if ($request->input('category_id') == 'all' ){
                $types = Type::where('name', 'LIKE', '%' . $request->search . '%')->with('images')->take(7)->get();
            } else {
                $types = Category::findOrFail($request->input('category_id'))
                ->types()
                ->where('types.name', 'LIKE', '%' . $request->search . '%')
                ->take(7)
                ->get();
            }
            if ($types) {
                foreach ($types as $key => $type) {
                    $output .= 
                    '<li class="mb-2">
                        <div class="row">
                            <div class="col-3">
                                <img src="'.$type->images[0]->name.'" alt="">
                            </div>
                            <div class="col-9">
                                <a href="'.url('types/'.$type->id).'"> 
                                    <p>'.$type->name.'</p>
                                </a>
                                <p>'.number_format($type->price).' đ</p>
                            </div>
                        </div>
                    </li>';
                }
                if ($output == ''){
                    $output = 
                    '<li>
                        <div class="row">
                            <div class="col-12">
                                <p class="p-3">Không tìm thấy sản phẩm</p>
                            </div>
                        </div>
                    </li>';
                }
            }
            return Response($output);
        }
    }
}
