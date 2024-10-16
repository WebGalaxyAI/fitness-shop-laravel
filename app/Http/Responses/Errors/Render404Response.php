<?php

namespace App\Http\Responses\Errors;

use Illuminate\Contracts\Support\Responsable;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class Render404Response implements Responsable
{
    public function toResponse($request): Response
    {
        return Inertia::render('Error', [
            'title' => __('404 page'),
            'error' => 404,
            'imagePath' => '/img/errors/bg-404.png',
            'text' => __("Sorry, but we didn't find this page"),
        ])
            ->toResponse($request)
            ->setStatusCode(404)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    }
}
