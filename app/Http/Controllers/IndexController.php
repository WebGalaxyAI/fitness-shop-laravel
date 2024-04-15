<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('type', 'main')->get();
        return Inertia::render('Home', [
            'title' => __('Home'),
            'sliders' => SliderResource::collection($sliders),
        ]);
    }
}
