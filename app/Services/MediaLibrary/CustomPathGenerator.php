<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{

    public function getPath(Media $media): string
    {
        return md5($media->uuid) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return md5($media->uuid) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return md5($media->uuid) . '/responsive-images/';
    }
}
