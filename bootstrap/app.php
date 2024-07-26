<?php

use App\Http\Responses\Errors\Render404Response;
use App\Http\Responses\Errors\Render500Response;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            'throttle:global',
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->alias([
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReportDuplicates()
            ->report(function (Throwable $e) {
                $className = get_class($e);
                logger()
                    ->channel('telegram')
                    ->error("🚨🆘😟 ❗❗❗{$className} \n. {$e->getMessage()}\n. File: {$e->getFile()}\n. Line: {$e->getLine()}");
            });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->route()) {
                return new Render404Response();
            }

            return (new Pipeline(app()))
                ->send($request)
                ->through([
                    Illuminate\Cookie\Middleware\EncryptCookies::class,
                    App\Http\Middleware\HandleInertiaRequests::class,
                ])
                ->then(function ($request) {
                    return (new Render404Response())->toResponse($request);
                });
        });

        if (app()->environment() != 'local' && request()->isMethod('GET')) {
            $exceptions->render(function (\ErrorException|\RuntimeException $exception, $request) {
                return new Render500Response();
            });
        }

    })->create();
