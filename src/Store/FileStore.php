<?php

namespace MarekVik\DependencyCache\Store;

use MarekVik\DependencyCache\Traits\CreateStoreDependenciesTrait;

class FileStore extends \Illuminate\Cache\FileStore
{
    use CreateStoreDependenciesTrait;
}