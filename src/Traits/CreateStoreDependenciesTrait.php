<?php

namespace MarekVik\DependencyCache\Traits;

use MarekVik\DependencyCache\DependencyCache;

trait CreateStoreDependenciesTrait
{
    /**
     * Begin executing a new dependency operation.
     *
     * @param  array|mixed  $dependencies
     *
     * @return DependencyCache
     */
    public function dependencies(mixed $dependencies): DependencyCache
    {
        return new DependencyCache(
            $this,
            is_array($dependencies) ? $dependencies : func_get_args(),
        );
    }
}