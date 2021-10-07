<?php

namespace App\Imports;

use App\Models\Type;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
class TypesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        if ($row['material'] == ''){
            return;
        }
        if ($row['sizes'] == ''){
            return;
        }
        if ($row['colors'] == ''){
            return;
        }
        if ($row['details'] == ''){
            return;
        }
        if ($row['designs'] == ''){
            return;
        }
        $model = Type::create([
            'name' => $row['name'],
            'price' => $row['price'],
            'initial_price' => $row['initial_price'],
            'sizes' => $row['sizes'],
            'designs' => $row['designs'],
            'details' => $row['details'],
            'material' => $row['material'],
            'color' => $row['colors'],
            'product_id' => 1,
            'created_at' => now(),
            'updated_at' => now()

        ]);

        $images = explode(',',$row['images']);
        foreach ($images as $image){
            Image::create([
                'name'=> $image,
                'color' => $row['colors'],
                'type_id' => $model->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        // $type_Id = Type::where('name',$row['name'])->first();
        // dd($type_Id);
        return;
    }
    // public function rules(): array
    // {
    //     return [
    //         'name' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'price' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'initial_price' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'images' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'designs' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'material' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'details' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'sizes' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         },
    //         'colors' => function($attribute, $value, $onFailure) {
    //             if ($value == '' || $value == 'none') {
    //                 $onFailure('error');
    //             }
    //         }

    //    ];
    //}
}

