<?php

namespace App\Services\Person\Interfaces;

use App\Services\Person\Data\Person;

interface PersonApiInterface
{
    public function getPerson(string $email): Person;
}
