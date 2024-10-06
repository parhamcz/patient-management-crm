<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\File as MediaFile;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_user', 'user_id', 'file_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function registerMediaCollections(): void
    {
        //User's Avatar
        $this
            ->addMediaCollection('user_avatar')
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
