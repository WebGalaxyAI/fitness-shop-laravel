<?php

namespace App\Models;

use Fureev\Trees\UseTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements Sortable
{
    use HasFactory, UseTree, SoftDeletes, HasTranslations, HasSlug, SortableTrait;

    public array $translatable = ['name'];

    protected static $unguarded = false;

    public $fillable = ['name', 'slug', 'order', 'image'];

    public function getCasts(): array
    {
        /**
         * HasTranslations trait method result
         * @var $translatable
         */
        $translatable = array_fill_keys($this->getTranslatableAttributes(), 'array');

        return array_merge(
            parent::getCasts(),
            $translatable,
        );
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    public function getImgUrl(): string
    {
        if ($this->image) {
            return url('storage/' . $this->image);
        }
        return url('img/no-img-available.png');
    }

    public function getCatalogUrl(): string
    {
        return route('catalog', [
            'category' => $this->slug,
        ]);
    }
}
