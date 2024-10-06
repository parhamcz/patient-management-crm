<?php

namespace App\Actions\Auth;

use App\Enums\UserRoleEnum;
use App\Http\Resources\Tiny\TinyUserResource;
use App\Http\Resources\UserResource;
use App\Interfaces\Actions\LoginAction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserLoginAction implements LoginAction
{
    public function __construct()
    {

    }

    public function execute(
        array        $entry,
        string       $password,
        UserRoleEnum $role = UserRoleEnum::doctor
    ): array
    {
        $entry_type = array_keys($entry)[0];
        $entry_value = array_values($entry)[0];
        $result = [];
        $user = User::where($entry_type, $entry_value)
            ->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {

                $result = $this->getUserLoginResult($user);
                $user->last_login_at = now();
                $user->save();

            }
        }
        return $result;
    }

    public function getUserLoginResult(User $user): array
    {
        return [
            'user' => TinyUserResource::make($user),
            'access_token' => $user->createToken('App Access Token')->accessToken,
            'last_login' => Carbon::create($user->last_login_at)->format('Y-m-d H:i:s'),
        ];
    }
}
