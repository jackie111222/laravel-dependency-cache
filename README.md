The main purpose of cache dependencies is to create connection of various cache items with each other by specific identifiers. This functionality is intended to help with simple work with the invalidation of cache records that chain each other. The programmer does not have to remember all the names of the cache keys or the exact sequence of cache tags from which he wants to delete cached items. You just have to set dependencies and invalidate them.

Supported cache drivers: Array, File, Null, Redis

Supported laravel version: >= 9.0


Cache dependencies usage example:

When storing records in the cache, you can set the dependencies like:

```
Cache::dependencies('my_cache_dependency')->set('test_item', 1);
Cache::tags(['taggroup_1', 'taggroup_2'])->dependencies('my_cache_dependency')->set('test_item', 1);
```

Also setting more dependencies for cached item is supported as well, you just have to set them as an array:

```
Cache::dependencies(['my_cache_dependency', 'another_cache_dependency'])->set('test_item', 1);
```

Or you can set dependencies as key, value pair: (this is useful if you want to make cache dependency by specific identifier/s from database etc.)

```
Cache::dependencies(['product' => [1]])->set('test_item', 1);
Cache::dependencies(['product' => [1, 2, 3, ..etc]])->set('test_item2’, 1);
```

If you want to invalidate (remove) all the records from the cache that have set specific dependency or dependencies, you can use one of the following codes:

```
Cache::dependencies('my_cache_dependency')->invalidate();
Cache::dependencies(['my_cache_dependency', 'another_cache_dependency'])->invalidate();
Cache::dependencies(['product' => [1]])->invalidate();
```
