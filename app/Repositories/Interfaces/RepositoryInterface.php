<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Model;
}
