<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExcelUploadRequest;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\UploadRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\UserResource;
use App\Imports\PatientsImport;
use App\Models\Patient;
use App\Models\User;
use App\Services\PatientService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PatientController extends Controller
{
    use HasResponse;

    protected PatientService $patientService;

    public function __construct()
    {
        $this->patientService = new PatientService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $patients = Patient::query()
            ->orderBy('created_at', 'DESC')
            ->paginate(15)->through(function ($patient) {
                return PatientResource::make($patient);
            });
        return $this->ok(
            data: $patients,
            message: "Patients fetched successfully."
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request): JsonResponse
    {
        $patient = Patient::query()->create([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'gender' => $request->gender,
            'education_degree' => $request->education_degree,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count ?? 0,
            'occupation' => $request->occupation,
            'first_visit_at' => $request->first_visit_at,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'patient_avatar' => $request->patient_avatar,
        ]);
        $file = $patient->files()->create([
            'visit_date' => $request->visit_date,
            'patient_accompany' => $request->patient_accompany,
            'case_number' => $request->case_number,
            'medical_history' => $request->medical_history,
            'before_operation' => $request->before_operation,
            'during_operation' => $request->during_operation,
            'after_operation' => $request->after_operation,
            'disease_comparison' => $request->disease_comparison,
            'special_case' => $request->special_case,
        ]);
        $file->hospitals()->sync($request->hospitals);
        $file->diseases()->sync($request->diseases);
        $file->congresses()->sync($request->congresses);
        $file->users()->sync($request->doctors);

        return $this->created(
            data: PatientResource::make($patient),
            message: "Patient created successfully."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient): JsonResponse
    {
        return $this->ok(
            data: PatientResource::make($patient),
            message: "Patient fetched successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientStoreRequest $request, Patient $patient)//: JsonResponse
    {
        $patient->update([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'gender' => $request->gender,
            'education_degree' => $request->education_degree,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count ?? 0,
            'occupation' => $request->occupation,
            'first_visit_at' => $request->first_visit_at,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'patient_avatar' => $request->patient_avatar,
        ]);
        $file = $patient->files()->orderBy('updated_at', 'desc')->first();
        $file->update([
            'visit_date' => $request->visit_date,
            'patient_accompany' => $request->patient_accompany,
            'case_number' => $request->case_number,
            'medical_history' => $request->medical_history,
            'before_operation' => $request->before_operation,
            'during_operation' => $request->during_operation,
            'after_operation' => $request->after_operation,
            'disease_comparison' => $request->disease_comparison,
            'special_case' => $request->special_case,
        ]);
        $file->hospitals()->sync($request->hospitals);
        $file->diseases()->sync($request->diseases);
        $file->congresses()->sync($request->congresses);
        $file->users()->sync($request->doctors);
        $file->save();
        $file->refresh();
        return $this->ok(
            data: PatientResource::make($patient),
            message: "Patient updated successfully."
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();
        return $this->ok(
            message: "Patient deleted successfully."
        );
    }

    /**
     * @param UploadRequest $request
     * @param Patient $patient
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadAvatar(UploadRequest $request, Patient $patient): JsonResponse
    {
        $patient->addMediaFromRequest('upload')->toMediaCollection('patient_avatar');
        return $this->ok(
            data: PatientResource::make($patient),
            message: "Patient's avatar uploaded successfully."
        );
    }

    /**
     * Imports patients information from an excel file.
     * @return JsonResponse
     */
    public function importExcelFile(ExcelUploadRequest $request)
    {
        Excel::import(new PatientsImport(), $request->file('upload'));
        return $this->ok(
            message: "Patients excel file imported successfully."
        );
    }
}
