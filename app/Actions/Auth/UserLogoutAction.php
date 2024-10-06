<?php

namespace App\Actions\Auth;

use App\Interfaces\Actions\LogoutAction;
use App\Models\User;

class UserLogoutAction implements LogoutAction
{
    public function __construct()
    {

    }

    public function execute(
        User $user
    ): bool
    {
        if ($user->token()) {
            $user->token()->revoke();
            return true;
        }
        return false;
    }
}
