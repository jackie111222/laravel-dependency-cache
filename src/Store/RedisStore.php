<?php

namespace MarekVik\DependencyCache\Store;

use MarekVik\DependencyCache\Traits\CreateStoreDependenciesTrait;

class RedisStore extends \Illuminate\Cache\RedisStore
{
    use CreateStoreDependenciesTrait;
}