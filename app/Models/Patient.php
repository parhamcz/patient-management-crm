<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File as MediaFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Patient extends Model implements HasMedia
{
    use HasFactory, HasRelationships, InteractsWithMedia;

    protected $fillable = [
        'name',
        'gender',
        'national_id',
        'phone_number',
        'birthdate',
        'education_degree',
        'marital_status',
        'children_count',
        'occupation',
        'first_visit_at',
        'address'
    ];

    protected $casts = [
        'national_id' => 'string',
        'first_visit_at' => 'date'
    ];
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function hospitals(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->files(), (new File())->hospitals());
    }

    public function diseases(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->files(), (new File())->diseases());
    }

    public function users(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->files(), (new File())->users());
    }

    public function congresses(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->files(), (new File())->congresses());
    }

    public function age()
    {
        return Carbon::create($this->birthdate)->age;
    }

    public function registerMediaCollections(): void
    {
        //User's Avatar
        $this
            ->addMediaCollection('patient_avatar')
            ->acceptsFile(function (MediaFile $file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/jpg']);
            })
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $thumbnail_size = config('setting.image_sizes.thumbnail_size');
        $medium_size = config('setting.image_sizes.medium_size');
        $this
            ->addMediaConversion('thumbnail')
            ->nonQueued() //TODO add Queue for optimization
            ->width($thumbnail_size)
            ->height($thumbnail_size);
        $this
            ->addMediaConversion('medium')
            ->nonQueued()
            ->width($medium_size)
            ->height($medium_size);
    }
}
