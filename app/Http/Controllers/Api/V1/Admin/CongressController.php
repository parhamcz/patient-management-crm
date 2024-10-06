<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CongressStoreRequest;
use App\Http\Resources\CongressResource;
use App\Models\Congress;
use App\Services\CongressService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CongressController extends Controller
{
    use HasResponse;

    protected CongressService $congressService;

    public function __construct()
    {
        $this->congressService = new CongressService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->ok(
            data: CongressResource::collection(Congress::get()),
            message: "Congresses fetched successfully."
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CongressStoreRequest $request): JsonResponse
    {
        return $this->created(
            data: CongressResource::make($this->congressService->store($request->all())),
            message: "Congress stored successfully."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Congress $congress): JsonResponse
    {
        return $this->ok(
            data: CongressResource::make($congress),
            message: "Congress fetched successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CongressStoreRequest $request, Congress $congress): JsonResponse
    {
        return $this->ok(
            data: CongressResource::make($this->congressService->update($congress, $request->all()),
                message: "Congress updated successfully."
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Congress $congress): JsonResponse
    {
        $congress->delete();
        return $this->ok(
            message: "Congress deleted successfully."
        );
    }
}
