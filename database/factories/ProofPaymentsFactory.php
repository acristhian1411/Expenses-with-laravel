<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PaymentTypes;

class ProofPaymentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $payment_types = PaymentTypes::factory()->create();
        return [
            //
            'proof_payment_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'payment_type_id' => $payment_types->id,
        ];
    }
}
