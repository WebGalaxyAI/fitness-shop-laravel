<?php

namespace App\Http\Responses\Errors;

use Illuminate\Contracts\Support\Responsable;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class Render404Response implements Responsable
{
    public function toResponse($request): Response
    {
        return Inertia::render('Errors/404', [
            'title' => __('404 page'),
            'error' => 404,
            'text' => __("Sorry, but we didn't find this page"),
        ])
            ->toResponse($request)
            ->setStatusCode(404);
    }
}
