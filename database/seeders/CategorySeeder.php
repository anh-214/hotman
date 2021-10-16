<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category::factory(5)->create();
        Category::insert([
            'name' => 'Áo',
            'desc' => '.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
