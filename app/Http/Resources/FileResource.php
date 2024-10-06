<?php

namespace App\Http\Resources;

use App\Http\Resources\Tiny\TinyPatientResource;
use App\Http\Resources\Tiny\TinyUserResource;
use App\Models\File;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'patient' => TinyPatientResource::make($this->patient),
            'doctors' => TinyUserResource::collection($this->users),
            'uploads' => [
                'medical_history' => DocumentResource::collection($this->getMedia('medical_history')),
                'before_operation' => DocumentResource::collection($this->getMedia('before_operation')),
                'during_operation' => DocumentResource::collection($this->getMedia('during_operation')),
                'after_operation' => DocumentResource::collection($this->getMedia('after_operation')),
                'disease_comparison' => DocumentResource::collection($this->getMedia('disease_comparison')),
            ],
            'medical_history' => $this->medical_history,
            'before_operation' => $this->before_operation,
            'during_operation' => $this->during_operation,
            'after_operation' => $this->after_operation,
            'disease_comparison' => $this->disease_comparison,
            'hospitals' => HospitalResource::collection($this->hospitals),
            'congresses' => CongressResource::collection($this->congresses),
        ];
    }
}
