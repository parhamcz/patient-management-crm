<?php

namespace App\Http\Resources\Tiny;

use App\Http\Resources\DocumentResource;
use App\Http\Resources\FileResource;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TinyPatientResource extends JsonResource
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
            'birthdate' => $this->birthdate,
            'age' => $this->age(),
            'avatar' => DocumentResource::make($this->getFirstMedia()),
        ];
    }
}
