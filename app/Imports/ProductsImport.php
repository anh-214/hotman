<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{ 
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // asin,Title,MainImage,Rating,NumberOfReviews,Price,AvailableSizes,AvailableColors,BulletPoints,SellerRank
    public function model(array $row)
    {   

        
        return new Product([
            'asin'     => $row['asin'],
            'title'    => $row['title'], 
            'imageMain'=> $row['mainimage'], 
            'price'    => $row['price'], 
            'sizes'    => $row['availablesizes'], 
            'colors'    => $row['availablecolors'], 
            'feature_bullets' => $row['bulletpoints'],
        ]);
    }
}
