<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasFactory, SoftDeletes, HasSlug, HasTranslations;

    public array $translatable = ['name'];

    public $fillable = [
        'code',
        'name',
        'frontend_type',
        'is_required',
        'is_filterable',
    ];

    protected $casts  = [
        'is_required'   =>  'boolean',
        'is_filterable' =>  'boolean',
    ];

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('code');
    }

}
