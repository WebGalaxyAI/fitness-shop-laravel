<?php

namespace App\Managers;

use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategoryManager
{
    private string $imgDirectory = 'categories';

    public function saveCategoryImg(string $url, Category $category): bool
    {
        $response = Http::get($url);
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        $filePath = $this->imgDirectory . '/' . $category->slug . '.' . $extension;

        if ($response->successful()) {
            Storage::put('public/' . $filePath, $response->body());
            $category->image = $filePath;
            $category->save();
            return true;
        }

        return false;
    }
}
