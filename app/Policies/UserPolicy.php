<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any users');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('view users');
    }

    public function create(User $user): bool
    {
        return $user->can('create users');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('edit users');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('delete users');
    }
}
