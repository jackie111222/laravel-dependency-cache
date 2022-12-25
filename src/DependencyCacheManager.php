<?php

namespace MarekVik\DependencyCache;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Repository;
use MarekVik\DependencyCache\Store\ArrayStore;
use MarekVik\DependencyCache\Store\FileStore;
use MarekVik\DependencyCache\Store\NullStore;
use MarekVik\DependencyCache\Store\RedisStore;

class DependencyCacheManager extends CacheManager
{
    /**
     * Create an instance of the array cache driver.
     *
     * @param  array  $config
     * @return \Illuminate\Cache\Repository
     */
    protected function createArrayDriver(array $config): Repository
    {
        return $this->repository(new ArrayStore($config['serialize'] ?? false));
    }

    /**
     * Create an instance of the file cache driver.
     *
     * @param  array  $config
     * @return \Illuminate\Cache\Repository
     */
    protected function createFileDriver(array $config): Repository
    {
        return $this->repository(new FileStore($this->app['files'], $config['path'], $config['permission'] ?? null));
    }

    /**
     * Create an instance of the Null cache driver.
     *
     * @return \Illuminate\Cache\Repository
     */
    protected function createNullDriver(): Repository
    {
        return $this->repository(new NullStore);
    }

    /**
     * Create an instance of the Redis cache driver.
     *
     * @param  array  $config
     * @return \Illuminate\Cache\Repository
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
}