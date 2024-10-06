<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class File extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'medical_history',
        'before_operation',
        'during_operation',
        'after_operation',
        'disease_comparison',
        'patient_id',
        "visit_date",
        "patient_accompany",
        "case_number"
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospitals(): BelongsToMany
    {
        return $this->belongsToMany(Hospital::class, 'file_hospital', 'file_id', 'hospital_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'file_user', 'file_id', 'user_id');
    }

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'disease_file', 'file_id', 'disease_id');
    }

    public function congresses(): BelongsToMany
    {
        return $this->belongsToMany(Congress::class, 'congress_file', 'file_id', 'congress_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('medical_history');
        $this->addMediaCollection('before_operation');
        $this->addMediaCollection('during_operation');
        $this->addMediaCollection('after_operation');
        $this->addMediaCollection('disease_comparison');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $thumbnail_size = config('setting.image_sizes.thumbnail_size');
        $medium_size = config('setting.image_sizes.medium_size');
//        $this
//            ->addMediaConversion('thumbnail')
//            ->nonQueued() //TODO add Queue for optimization
//            ->width($thumbnail_size)
//            ->height($thumbnail_size);
//        $this
//            ->addMediaConversion('medium')
//            ->nonQueued()
//            ->width($medium_size)
//            ->height($medium_size);
    }
}
