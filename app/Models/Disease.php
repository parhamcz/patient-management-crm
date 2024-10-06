<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Disease extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'name'
    ];

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'disease_file');
    }

    public function patients(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->files(), (new File())->patient());
    }
}
