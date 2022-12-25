<?php

namespace MarekVik\DependencyCache\Store;

use MarekVik\DependencyCache\Traits\CreateStoreDependenciesTrait;

class NullStore extends \Illuminate\Cache\NullStore
{
    use CreateStoreDependenciesTrait;
}