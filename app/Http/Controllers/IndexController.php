<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SliderResource;
use App\Models\Brand;
use App\Models\Slider;
use App\Repositories\CategoryRepository;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index(CategoryRepository $catRepository)
    {
        $sliders = Slider::where('type', 'main')->get();
        $brands = Brand::query()->orderBy('order')->take(15)->get();
        return Inertia::render('Home', [
            'title' => __('Home'),
            'sliders' => SliderResource::collection($sliders),
            'brands' => BrandResource::collection($brands),
            'homeGymCats' => CategoryResource::collection($catRepository->homeGymCats(10)),
            'fitnessClubGymCats' => CategoryResource::collection($catRepository->fitnessClubGymCats(7)),
        ]);
    }
}
