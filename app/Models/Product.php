<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, HasSlug, InteractsWithMedia;

    protected $table = 'products';

    public array $translatable = ['name', 'description',];

    protected $fillable = [
        'brand_id', 'sku', 'name', 'slug', 'description',
        'quantity', 'price', 'sale_price', 'active',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'brand_id' => 'integer',
        'active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Model $model) {
            $model->generateSkuOnCreate();
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_value_product');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    public function getFirstImgUrl(): string
    {
        return $this->getFirstMedia()?->getUrl() ?? url('img/no-img-available.png');
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => $value ? $value / 100 : null,
            set: static fn($value) => $value ? $value * 100 : null,
        );
    }

    protected function salePrice(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => $value ? $value / 100 : null,
            set: static fn($value) => $value ? $value * 100 : null,
        );
    }

    protected function generateSkuOnCreate()
    {
        $this->sku = str($this->slug)
            ->upper()
            ->substr(0, 5)
            ->append(rand(10000, 99999));
    }

    public function getUrl(): string
    {
        return route('product', $this->slug);
    }
}
