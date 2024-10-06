<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\UserController as ParentUserController;
use App\Http\Requests\UploadRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\Tiny\TinyUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserController extends ParentUserController
{

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->ok(
            data: UserResource::collection(User::query()->orderBy('created_at', 'DESC')->get()),
            message: "User's list fetched successfully."
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        return $this->created(
            data: UserResource::make($this->userService->store($request->all())),
            message: "User was created successfully."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return $this->ok(
            data: UserResource::make($user),
            message: "User fetched successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user): JsonResponse
    {
        return $this->ok(
            data: UserResource::make($this->userService->update($user, $request->all())),
            message: "User was updated successfully."
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->ok(
            message: "User was deleted successfully."
        );
    }

    /**
     * Uploads an image for doctor's avatar.
     * @param UploadRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadAvatar(UploadRequest $request, User $user): JsonResponse
    {
        $user->addMediaFromRequest('upload')->toMediaCollection('user_avatar');
        return $this->ok(
            data: UserResource::make($user),
            message: "User's avatar uploaded successfully."
        );
    }
}
