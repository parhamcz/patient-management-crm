<?php

namespace App\Http\Resources;

use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**@param $this Disease */
        return [
            'id' => $this->id,
            'name' => $this->name
        ];    }
}
