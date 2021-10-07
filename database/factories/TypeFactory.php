<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class TypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Type::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productIDs = DB::table('products')->pluck('id');
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numerify('######'),
            'initial_price' => $this->faker->numerify('######'),
            'sizes' => $this->faker->name(),
            'designs' => $this->faker->name(),
            'details' => $this->faker->name(),
            'material' => $this->faker->name(),
            'color' => $this->faker->name(),
            'product_id' => $this->faker->randomElement($productIDs),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
