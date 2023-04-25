<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'UserGems',
            'linkedin_url' => $this->faker->url,
            'employees' => $this->faker->numberBetween(0, 5000),
        ];
    }
}
