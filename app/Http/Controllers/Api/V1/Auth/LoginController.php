<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\UserLoginAction;
use App\Actions\Auth\UserLogoutAction;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Interfaces\Actions\LoginAction;
use App\Interfaces\Actions\LogoutAction;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HasResponse;

    private LoginAction $loginAction;
    private LogoutAction $logoutAction;

    public function __construct()
    {
        $this->loginAction = new UserLoginAction();
        $this->logoutAction = new UserLogoutAction();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $entry = ['phone_number' => $request->phone_number];
        $result = $this->loginAction->execute($entry, $request->password);
        if ($result) {
            return $this->ok($result, 'Login Successful');
        }
        return $this->unauthorized('Invalid Credentials!');
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $logout_result = $this->logoutAction->execute($user);
        if ($logout_result) {
            return $this->ok(
                message: 'Logout Successful',
            );
        }
        return $this->badRequest(
            message: 'Invalid or Expired token.'
        );
    }
}
