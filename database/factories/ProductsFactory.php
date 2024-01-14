<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categories;
use App\Models\IvaType;
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ivatypes = IvaType::factory()->count(3)->create();
        $categories = Categories::factory()->count(3)->create();
        return [
            //
            'product_name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'product_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'product_cost_price' => $this->faker->randomFloat(2, 0, 100),
            'product_quantity' => $this->faker->randomDigitNotNull(),
            'product_selling_price' => $this->faker->randomFloat(2, 0, 100),
            'category_id' => $categories->random()->id, 
            'iva_type_id' => $ivatypes->random()->id, 
        ];
    }
}