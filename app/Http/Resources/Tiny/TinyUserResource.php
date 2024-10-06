<?php

namespace App\Http\Resources\Tiny;

use App\Http\Resources\DocumentResource;
use App\Http\Resources\FileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TinyUserResource extends JsonResource
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
            'email' => $this->email,
            'roles' => $this->roles,
            'avatar' => DocumentResource::collection($this->getMedia('user_avatar')),
            'last_login_at' => $this->last_login_at,
        ];
    }
}
