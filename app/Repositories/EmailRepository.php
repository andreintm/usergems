<?php

namespace App\Repositories;

use App\Models\Email;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

class EmailRepository implements EmailRepositoryInterface
{

    public function all(): Collection
    {
        return Email::all();
    }

    public function find(int $id): Model
    {
        return Email::query()->find($id);
    }

    public function save(User $user, array $attributes): Model
    {
        return $user->emails()->create($attributes);
    }

    /**
     * @throws Throwable
     */
    public function update(Email $email, array $attributes): bool
    {
        return $email->updateOrFail($attributes);
    }
}
