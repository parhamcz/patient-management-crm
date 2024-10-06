<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use App\Http\Resources\Tiny\TinyFileResource;
use App\Models\File;
use App\Services\FileService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FileController extends Controller
{
    use HasResponse;

    protected FileService $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->ok(
            data: FileResource::collection(File::query()->orderBy('created_at', 'DESC')->get()),
            message: "Files fetched successfully."
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileStoreRequest $request): JsonResponse
    {
        return $this->created(
            data: FileResource::make($this->fileService->store($request->validated())),
            message: "File stored successfully."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file): JsonResponse
    {
        return $this->ok(
            data: FileResource::make($file),
            message: "File fetched successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileStoreRequest $request, File $file): JsonResponse
    {
        return $this->ok(
            data: FileResource::make($this->fileService->update($file, $request->validated())),
            message: "File updated successfully."
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file): JsonResponse
    {
        $file->delete();
        return $this->ok(
            message: "File deleted successfully."
        );
    }

    /**
     * Uploads a file for file's medical history collection.
     * @param FileUploadRequest $request
     * @param File $file
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadMedicalHistory(FileUploadRequest $request, File $file): JsonResponse
    {
        $file->addMediaFromRequest('upload')->toMediaCollection('medical_history');
        $file->medical_history = $request->input("upload") ?? 'uploaded';
        $file->save();
        return $this->ok(
            data: FileResource::make($file),
            message: "File's medical history uploaded successfully."
        );
    }

    /**
     * Uploads a file for file's before operation collection.
     * @param FileUploadRequest $request
     * @param File $file
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadBeforeOperation(FileUploadRequest $request, File $file): JsonResponse
    {
        $file->addMediaFromRequest('upload')->toMediaCollection('before_operation');
        $file->before_operation = $request->input("upload") ?? 'uploaded';
        $file->save();
        return $this->ok(
            data: FileResource::make($file),
            message: "File's before operation uploaded successfully."
        );
    }

    /**
     * Uploads a file for file's during operation collection.
     * @param FileUploadRequest $request
     * @param File $file
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadDuringOperation(FileUploadRequest $request, File $file): JsonResponse
    {
        $file->addMediaFromRequest('upload')->toMediaCollection('during_operation');
        $file->during_operation = $request->input("upload") ?? 'uploaded';
        $file->save();
        return $this->ok(
            data: FileResource::make($file),
            message: "File's during operation uploaded successfully."
        );
    }

    /**
     * Uploads a file for file's after operation collection.
     * @param FileUploadRequest $request
     * @param File $file
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadAfterOperation(FileUploadRequest $request, File $file): JsonResponse
    {
        $file->addMediaFromRequest('upload')->toMediaCollection('after_operation');
        $file->after_operation = $request->input("upload") ?? 'uploaded';
        $file->save();
        return $this->ok(
            data: FileResource::make($file),
            message: "File's after operation uploaded successfully."
        );
    }

    /**
     * Uploads a file for file's disease comparison collection.
     * @param FileUploadRequest $request
     * @param File $file
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadDiseaseComparison(FileUploadRequest $request, File $file): JsonResponse
    {
        $file->addMediaFromRequest('upload')->toMediaCollection('disease_comparison');
        $file->disease_comparison = $request->input("upload") ?? 'uploaded';
        $file->save();
        return $this->ok(
            data: FileResource::make($file),
            message: "File's disease comparison uploaded successfully."
        );
    }
}
