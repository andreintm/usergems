<?php

namespace Database\Factories;

use App\Models\Attendee;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calendar_api_key' => $this->faker->randomKey,
            'attendee_id' => Attendee::factory()
        ];
    }
}
