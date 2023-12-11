<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transaction = Transaction::factory()->create();
        return [
            'transaction_id' => $transaction->id,
            'amount' => random_int(100,$transaction->amount),
            'paid_on' =>  $this->faker->dateTimeThisMonth->format('Y-m-d'),
            'details' => $this->faker->text
        ];
    }
}
