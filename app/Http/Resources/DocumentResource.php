<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Media $this */
        return [
            'id' => $this->id,
            'title' => $this->name,
            'link' => $this->getUrl(),
//            'thumbnail_link' => $this->getUrl('thumbnail'),
            'meta' => [
                'type' => $this->mime_type,
                'size' => $this->size,
                'uploaded_at' => Carbon::createFromTimeString($this->created_at)->diffForHumans(Carbon::now()),
            ],
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i:s'),
//            'sizes' => [
//                'large' => $this->size(),
//                'medium' => $this->getUrl('medium'),
//                'thumbnail' => $this->getUrl('thumbnail'),
//            ]
        ];
    }
}
