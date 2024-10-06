<?php

namespace App\Http\Resources;

use App\Models\Congress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CongressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**@param $this Congress */
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
