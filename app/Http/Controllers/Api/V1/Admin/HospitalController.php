<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalStoreRequest;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Services\HospitalService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

class HospitalController extends Controller
{
    use HasResponse;

    protected HospitalService $hospitalService;

    public function __construct()
    {
        $this->hospitalService = new HospitalService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->ok(
            data: HospitalResource::collection(Hospital::get()),
            message: "Hospitals fetched successfully."
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HospitalStoreRequest $request): JsonResponse
    {
        return $this->created(
            data: HospitalResource::make($this->hospitalService->store($request->all())),
            message: "Hospital stored successfully."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital): JsonResponse
    {
        return $this->ok(
            data: HospitalResource::make($hospital),
            message: "Hospital fetched successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HospitalStoreRequest $request, Hospital $hospital): JsonResponse
    {
        return $this->ok(
            data: HospitalResource::make($this->hospitalService->update($hospital, $request->all()),
                message: "Hospital updated successfully."
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital): JsonResponse
    {
        $hospital->delete();
        return $this->ok(
            message: "Hospital deleted successfully."
        );
    }
}
