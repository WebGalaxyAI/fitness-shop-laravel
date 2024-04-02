<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class AttributeValue extends Model
{
    use HasFactory, HasTranslations, HasSlug;

    public array $translatable = ['value'];

    public $fillable = [
        'attribute_id',
        'code',
        'value',
    ];

    protected $casts = [
        'attribute_id' => 'integer',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function scopeWithAttributeName(Builder $q): Builder
    {
        return $q->select(
            'attribute_values.*',
            'attributes.name'
        )->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('value')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('code');
    }
}
