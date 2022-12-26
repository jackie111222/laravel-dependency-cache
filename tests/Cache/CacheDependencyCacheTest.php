<?php

namespace Illuminate\Tests\Cache;

use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\FileStore;
use Illuminate\Cache\NullStore;
use Illuminate\Filesystem\Filesystem;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class CacheDependencyCacheTest extends TestCase {
    protected function tearDown(): void
    {
        m::close();
    }

    public function testCacheDependencySetBasicItem()
    {
        $store = new ArrayStore;
        $dependencies = 'dependencies_group';

        $store->dependencies($dependencies)->put('foo', 'bar', 10);

        $this->assertTrue($store->dependencies($dependencies)->exists());
    }

    public function testCacheDependencyInvalidateBasicItem()
    {
        $store = new ArrayStore;
        $dependencies = 'dependencies_group';

        $store->dependencies($dependencies)->put('foo', 'bar', 10);
        $store->dependencies($dependencies)->invalidate();

        $this->assertNull($store->get('foo'));
    }

    public function testFileStoreDependencyInvalidateBasicItem()
    {
        $files = $this->mockFilesystem();

        $store = new FileStore($files, __DIR__);
        $dependencies = 'dependencies_group';

        $store->dependencies($dependencies)->put('foo', 'bar', 10);
        $store->dependencies($dependencies)->invalidate();

        $this->assertNull($store->get('foo'));
    }

    public function testNullStoreDependencyInvalidateBasicItem()
    {
        $store = new NullStore();
        $dependencies = 'dependencies_group';

        $store->dependencies($dependencies)->put('foo', 'bar', 10);
        $store->dependencies($dependencies)->invalidate();

        $this->assertFalse($store->dependencies($dependencies)->exists());
    }

    protected function mockFilesystem()
    {
        return $this->createMock(Filesystem::class);
    }
}
