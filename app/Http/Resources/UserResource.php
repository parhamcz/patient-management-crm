<?php

namespace App\Http\Resources;

use App\Http\Resources\Tiny\TinyFileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @param $this User */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'roles' => $this->roles,
            'email' => $this->email,
            'last_login_at' => $this->last_login_at,
            'files' => TinyFileResource::collection($this->files),
        ];
    }
}
