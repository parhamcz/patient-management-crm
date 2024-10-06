<?php

namespace App\Http\Resources\Tiny;

use App\Http\Resources\CongressResource;
use App\Http\Resources\DiseaseResource;
use App\Http\Resources\HospitalResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TinyFileWithoutPatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @param $this File */
        return [
            'id' => $this->id,
            'case_number' => $this->case_number,
            'visit_date' => $this->visit_date,
            'patient_accompany' => $this->patient_accompany,
            'diseases' => DiseaseResource::collection($this->diseases),
            'special_case' => $this->special_case,
            'doctors' => TinyUserResource::collection($this->users),
            'hospitals' => HospitalResource::collection($this->hospitals),
            'congresses' => CongressResource::collection($this->congresses),
            'medical_history' => $this->medical_history,
            'before_operation' => $this->before_operation,
            'during_operation' => $this->during_operation,
            'after_operation' => $this->after_operation,
            'disease_comparison' => $this->disease_comparison,
        ];
    }
}
