<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): Model
    {
        return User::query()->findOrFail($id);
    }

    public function chunk(int $records, callable $callback): void
    {
        User::query()->chunk($records, $callback);
    }

    public function hasEmailSent(User $user): bool
    {
        return $user->emails()->whereDate('created_at', now()->format('Y-m-d'))->exists();
    }
}
