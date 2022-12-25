<?php

namespace MarekVik\DependencyCache\Store;

use MarekVik\DependencyCache\DependencyCache;

class Repository extends \Illuminate\Cache\Repository
{
    /**
     * Begin executing a new dependency operation.
     *
     * @param array|mixed $dependencies
     *
     * @return DependencyCache
     */
    public function dependencies(mixed $dependencies): DependencyCache
    {
        return new DependencyCache(
            $this->store,
            is_array($dependencies) ? $dependencies : func_get_args(),
            $this->supportsTags() ? ($this->tags ?? null) : null
        );
    }
}