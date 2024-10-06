<?php

namespace App\Interfaces\Actions;

use App\Enums\UserRoleEnum;
use App\Models\User;

interface LoginAction
{
    public function execute(array $entry, string $password, UserRoleEnum $role = UserRoleEnum::doctor): array;

    public function getUserLoginResult(User $user): array;
}
