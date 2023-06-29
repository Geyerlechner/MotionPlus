<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deadline'          => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'priority'          => $this->faker->numberBetween(0, 10),
            'estimated_effort'  => $this->faker->randomDigit(),
            'actual_expense'    => $this->faker->randomDigit()
        ];
    }
}
