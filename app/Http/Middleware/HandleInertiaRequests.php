<?php

namespace App\Http\Middleware;

use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use App\Repositories\FavoriteProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $catRepository = app(CategoryRepository::class);
        $favoriteRepository = app(FavoriteProductsRepository::class);
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'canAccessAdminPanel' => $request->user()?->canAccessAdminPanel(),
            ],
            'flash' => [
                'message' => $request->session()->get('message'),
                'errors' => $request->session()->get('errors'),
            ],
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'locale' => function () {
                return app()->getLocale();
            },
            'catalogRootCats' => CategoryResource::collection($catRepository->catalogRootCats()),
            'language' => app('translator')
                ->getLoader()
                ->load(app()->getLocale(), '*', '*'),
            'languageSelector' => $this->generateSwitchLinks(),
            'favoriteIds' => $favoriteRepository->getIds($request),
        ];
    }

    private function generateSwitchLinks(): array
    {
        $links = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $links[$localeCode]['title'] = strtoupper($localeCode);
            $links[$localeCode]['href'] = LaravelLocalization::getLocalizedURL($localeCode);
            $links[$localeCode]['hreflang'] = $localeCode;
        }
        return $links;
    }
}
