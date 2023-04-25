<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserCredentialsSeeder extends Seeder
{
    private const CREDENTIALS = [
        [
            'email' => 'stephan@usergems.com',
            'name' => 'Stephan',
            'key' => '7S$16U^FmxkdV!1b',
        ],
        [
            'email' => 'christian@usergems.com',
            'name' => 'Christian',
            'key' => 'Ay@T3ZwF3YN^fZ@M',
        ],
        [
            'email' => 'joss@usergems.com',
            'name' => 'Joss',
            'key' => 'PK7UBPVeG%3pP9%B',
        ],
        [
            'email' => 'blaise@usergems.com',
            'name' => 'Blaise',
            'key' => 'c0R*4iQK21McwLww',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::factory()->create();

        foreach (self::CREDENTIALS as $user) {
            User::factory()
                ->for(
                    Attendee::factory()
                        ->state([
                            'email' => $user['email'],
                            'first_name' => $user['name'],
                            'company_id' => $company->id
                        ])
                )
                ->create([
                    'calendar_api_key' => $user['key'],
                ]);
        }
    }
}
