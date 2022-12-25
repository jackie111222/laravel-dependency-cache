<?php

namespace MarekVik\DependencyCache;

use Illuminate\Cache\CacheServiceProvider;

class DependencyCacheServiceProvider extends CacheServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cache', function ($app) {
            return new DependencyCacheManager($app);
        });

        $this->app->singleton('cache.store', function ($app) {
            return $app['cache']->driver();
        });
    }
}