<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\User;

class PatientService
{
    public function store($request): Patient
    {
        $patient = Patient::create([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'education_degree' => $request->education_degree,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count,
            'occupation' => $request->occupation,
            'first_visit_at' => $request->first_visit_at,
            'address' => $request->address,
        ]);
        if (isset($patient_data['patient_avatar'])) {
            $patient->addMedia($patient_data['patient_avatar'])->toMediaCollection('patient_avatar');
            $patient->refresh();
        }
        return $patient;
    }

    public function update(Patient $patient, array $patient_data): Patient
    {
        $patient->update($patient_data);
        if (isset($patient_data['patient_avatar'])) {
            $patient->addMedia($patient_data['patient_avatar'])->toMediaCollection('patient_avatar');
            $patient->refresh();
        }
        $patient->refresh();
        return $patient;
    }
}
