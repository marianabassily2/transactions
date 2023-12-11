<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => random_int(1000,1000000),
            'due_on' =>  $this->faker->dateTimeBetween('+0 days', '+2 years')->format('Y-m-d'),
            'vat' =>  random_int(0,50),
            'is_vat_inclusive' => $this->faker->boolean,
            'payer_id' => User::factory(),
            'status' => TransactionStatus::OUTSTANDING
        ];
    }
}
