<?php

namespace MarekVik\DependencyCache;

use Illuminate\Cache\ApcWrapper;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\HigherOrderTapProxy;
use MarekVik\DependencyCache\Store\ApcStore;
use MarekVik\DependencyCache\Store\ArrayStore;
use MarekVik\DependencyCache\Store\FileStore;
use MarekVik\DependencyCache\Store\NullStore;
use MarekVik\DependencyCache\Store\RedisStore;
use MarekVik\DependencyCache\Store\Repository;

class DependencyCacheManager extends CacheManager
{
    /**
     * Create an instance of the APC cache driver.
     *
     * @param  array  $config
     * @return Repository
     */
    protected function createApcDriver(array $config): Repository
    {
        $prefix = $this->getPrefix($config);

        return $this->repository(new ApcStore(new ApcWrapper, $prefix));
    }

    /**
     * Create an instance of the array cache driver.
     *
     * @param  array  $config
     * @return Repository
     */
    protected function createArrayDriver(array $config): Repository
    {
        return $this->repository(new ArrayStore($config['serialize'] ?? false));
    }

    /**
     * Create an instance of the file cache driver.
     *
     * @param  array  $config
     * @return Repository
     */
    protected function createFileDriver(array $config): Repository
    {
        return $this->repository(new FileStore($this->app['files'], $config['path'], $config['permission'] ?? null));
    }

    /**
     * Create an instance of the Null cache driver.
     *
     * @return Repository
     */
    protected function createNullDriver(): Repository
    {
        return $this->repository(new NullStore);
    }

    /**
     * Create an instance of the Redis cache driver.
     *
     * @param  array  $config
     * @return Repository
     */
    public function createRedisDriver(array $config): Repository
    {
        $redis = $this->app['redis'];

        $connection = $config['connection'] ?? 'default';

        $store = new RedisStore($redis, $this->getPrefix($config), $connection);

        return $this->repository(
            $store->setLockConnection($config['lock_connection'] ?? $connection)
        );
    }

    /**
     * Create a new cache repository with the given implementation.
     *
     * @param Store $store
     *
     * @return HigherOrderTapProxy|mixed
     */
    public function repository(Store $store): mixed
    {
        return tap(new Repository($store), function ($repository) {
            $this->setEventDispatcher($repository);
        });
    }
}