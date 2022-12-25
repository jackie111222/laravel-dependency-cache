<?php

namespace MarekVik\DependencyCache\Store;

use MarekVik\DependencyCache\Traits\CreateStoreDependenciesTrait;

class ArrayStore extends \Illuminate\Cache\ArrayStore
{
    use CreateStoreDependenciesTrait;
}