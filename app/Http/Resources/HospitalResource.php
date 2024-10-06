<?php

namespace App\Http\Resources;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**@param $this Hospital */
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
