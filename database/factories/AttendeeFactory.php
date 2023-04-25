<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'avatar_url' => $this->faker->imageUrl,
            'linkedin_url' => $this->faker->url,
            'company_id' => Company::factory()
        ];
    }
}
