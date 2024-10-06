<?php

namespace App\Http\Resources;

use App\Http\Resources\Tiny\TinyFileWithoutPatientResource;
use App\Models\Patient;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @param $this Patient */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'national_id' => $this->national_id,
            'occupation' => $this->occupation,
            'marital_status' => $this->marital_status,
            'education_degree' => $this->education_degree,
            'address' => $this->address,
            'first_visit_at' => $this->first_visit_at,
            'children_count' => $this->children_count,
            'birthdate' => Carbon::create($this->birthdate)->format('Y-m-d'),
            'age' => Carbon::create($this->birthdate)->age,
            'avatar' => DocumentResource::collection($this->getMedia('patient_avatar')),
            'cases' => TinyFileWithoutPatientResource::make($this->files()->orderBy('updated_at', 'DESC')->first()),
        ];
    }
}
