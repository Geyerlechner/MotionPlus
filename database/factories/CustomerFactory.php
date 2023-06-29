<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'         => $this->faker->companyEmail(),
            'companyname'   => $this->faker->company(),
            'phonenumber'   => $this->faker->phonenumber(),
            'website'       => $this->faker->domainName(),
            'address'       => $this->faker->city(),
            'status'        => $this->faker->randomElement(['Hohe Priorität', 'Mittlere Priorität', 'Niedrige Priorität', 'Blockierend'])
        ];
    }
}
