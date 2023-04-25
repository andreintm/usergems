<?php

namespace App\Services\Person\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Person extends Data
{
    public function __construct(
        public string $email,
        #[MapName('first_name')]
        public string|Optional $firstName,
        #[MapName('last_name')]
        public string|Optional $lastName,
        #[MapInputName('avatar')]
        #[MapOutputName('avatar_url')]
        public string|Optional $avatarUrl,
        public string|Optional $title,
        #[MapName('linkedin_url')]
        public string|Optional $linkedinUrl,
        public Company|Optional $company,
    ) {
    }
}
