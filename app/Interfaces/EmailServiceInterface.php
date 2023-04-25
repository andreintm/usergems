<?php

namespace App\Interfaces;

use App\Models\User;

interface EmailServiceInterface
{
    public function generate(User $user): array;
}
