<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    use HasFactory, HasUuids, Sluggable, HasUuids;

    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'number_of_days',
    ];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => $attribute['number_of_days'] - 1
        );
    }
}
