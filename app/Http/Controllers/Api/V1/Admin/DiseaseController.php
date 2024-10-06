<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiseaseStoreRequest;
use App\Http\Requests\ExcelUploadRequest;
use App\Http\Resources\DiseaseResource;
use App\Imports\DiseasesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Disease;
use App\Services\DiseaseService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{use HasResponse;

    protected DiseaseService $diseaseService;

    public function __construct()
    {
        $this->diseaseService = new DiseaseService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->ok(
            data: DiseaseResource::collection(Disease::get()),
            message: "Diseases fetched successfully."
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiseaseStoreRequest $request): JsonResponse
    {
        return $this->created(
            data: DiseaseResource::make($this->diseaseService->store($request->all())),
            message: "Disease stored successfully."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Disease $disease): JsonResponse
    {
        return $this->ok(
            data: DiseaseResource::make($disease),
            message: "Disease fetched successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiseaseStoreRequest $request, Disease $disease): JsonResponse
    {
        return $this->ok(
            data: DiseaseResource::make($this->diseaseService->update($disease, $request->all()),
                message: "Disease updated successfully."
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disease $disease): JsonResponse
    {
        $disease->delete();
        return $this->ok(
            message: "Disease deleted successfully."
        );
    }

    /**
     * Imports patients information from an excel file.
     * @return JsonResponse
     */
    public function importExcelFile(ExcelUploadRequest $request)
    {
        Excel::import(new DiseasesImport(), $request->file('upload'));
        return $this->ok(
            message: "Diseases excel file imported successfully."
        );
    }
}
