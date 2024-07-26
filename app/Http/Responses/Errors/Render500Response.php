<?php

namespace App\Http\Responses\Errors;

use Illuminate\Contracts\Support\Responsable;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class Render500Response implements Responsable
{
    public function toResponse($request): Response
    {
        return Inertia::render('Error', [
            'title' => __('500 page'),
            'error' => 500,
            'imagePath' => '/img/errors/bg-500.png',
            'text' => __("Unfortunately, an internal server error occurred"),
        ])
            ->toResponse($request)
            ->setStatusCode(500)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    }
}
