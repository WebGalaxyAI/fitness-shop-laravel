<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\ElasticsearhProductRepository;
use App\Repositories\ProductRepository;
use Carbon\CarbonInterval;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

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
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(1000);
        });

        Gate::before(function (User $user, string $ability) {
            return $user->hasRole('super admin') ? true : null;
        });

        JsonResource::withoutWrapping();
        ResourceCollection::withoutWrapping();

        $this->bindSearchClient();
        $this->classesBinding();
        if (app()->isProduction()) {
            $this->logLongRequests();
        }
    }

    public function logLongRequests()
    {
        DB::listen(function ($query) {
            if ($query->time > 100) {
                logger()
                    ->channel('telegram')
                    ->debug("🛠 Need fix SQL 👨🏾‍🔧🔧 \n Query longer then 1ms:  . $query->sql, $query->bindings");
            }
        });

        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function () {
                logger()->channel('telegram')
                    ->debug("⚙️ Need fix Request 👨🏾‍🔧🔧 \n Long term query: " . request()->url());
            }
        );
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
