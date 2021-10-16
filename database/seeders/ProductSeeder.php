<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Product::factory(15)->create();
        Product::insert([
            'name' => 'Áo dài tay nam',
            'desc' => '.',
            'category_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
