<?php

namespace App\Providers;

use App\Repositories\ElasticsearhProductRepository;
use App\Repositories\ProductRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });

        JsonResource::withoutWrapping();
        ResourceCollection::withoutWrapping();

        $this->bindSearchClient();
        $this->classesBinding();
    }

    private function classesBinding()
    {
        /** Repo */
        $this->app->bind(ProductRepository::class, ElasticsearhProductRepository::class);
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function () {
            return ClientBuilder::create()
                ->setHosts(config('database.elastic.hosts'))
                ->build();
        });
    }
}
