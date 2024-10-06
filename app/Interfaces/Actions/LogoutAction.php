<?php

namespace App\Interfaces\Actions;

use App\Models\User;

interface LogoutAction
{
    public function execute(User $user): bool;

}
