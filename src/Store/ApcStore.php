<?php

namespace MarekVik\DependencyCache\Store;

use MarekVik\DependencyCache\Traits\CreateStoreDependenciesTrait;

class ApcStore extends \Illuminate\Cache\ApcStore
{
    use CreateStoreDependenciesTrait;
}