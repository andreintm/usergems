<?php

namespace App\Services\Person\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class Company extends Data
{
    public function __construct(
        public string $name,
        #[MapName('linkedin_url')]
        public string $linkedinUrl,
        public int $employees,
    ) {
    }
}
