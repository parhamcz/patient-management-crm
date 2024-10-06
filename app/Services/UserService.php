<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function store(array $user_data): User
    {
        $user = User::create($user_data);
        if (isset($user_data['user_avatar'])) {
            $user->addMedia($user_data['user_avatar'])->toMediaCollection('user_avatar');
            $user->refresh();
        }
        return $this->syncRoles($user, $user_data['roles']);
    }

    public function syncRoles(User $user, array $roles_ids): User
    {
        $user->roles()->sync($roles_ids);
        $user->refresh();
        return $user;
    }

    public function update(User $user, array $user_data): User
    {
        $user->update($user_data);
        if (isset($user_data['user_avatar'])) {
            $user->addMedia($user_data['user_avatar'])->toMediaCollection('user_avatar');
            $user->refresh();
        }
        $user->refresh();
        return $user;
    }
}
