<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function homeGymCats(?int $limit = null): Collection
    {
        $homeGymCat = Category::query()
            ->with('children')
            ->whereJsonContains('name->uk', 'Тренажери для дому')
            ->first();
        if (!$homeGymCat) {
            return collect();
        }

        if ($limit) {
            return $homeGymCat->children->take($limit);
        }

        return $homeGymCat->children;
    }

    public function fitnessClubGymCats(?int $limit = null): Collection
    {
        $homeGymCat = Category::query()
            ->with('children')
            ->whereJsonContains('name->uk', 'Для фітнес клубів')
            ->first();
        if (!$homeGymCat) {
            return collect();
        }

        if ($limit) {
            return $homeGymCat->children->take($limit);
        }

        return $homeGymCat->children;
    }

    public function catalogRootCats(): Collection
    {
        return Category::query()
            ->root()
            ->with('children')
            ->orderBy('order')
            ->get();
    }
}
