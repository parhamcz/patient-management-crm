<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tiny\TinyUserResource;
use App\Models\Patient;
use App\Services\UserService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HasResponse;

    protected UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Returns current user's information.
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return $this->ok(
            data: TinyUserResource::make(Auth::user()),
            message: "User fetched successfully."
        );
    }
}
