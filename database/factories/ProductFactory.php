<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $categoryIDs = DB::table('categories')->pluck('id');
        return [
            'name' => $this->faker->name(),
            'desc' => $this->faker->text(10),
            'category_id' => $this->faker->randomElement($categoryIDs),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
