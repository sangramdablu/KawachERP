<?php

namespace App\Multitenancy;

use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Spatie\Permission\PermissionRegistrar;
use ReflectionClass;

class SwitchPermissionCacheTask implements SwitchTenantTask
{
    public function makeCurrent($tenant): void
    {
        $cacheKey = "spatie.permission.cache.tenant.{$tenant->id}";

        // Forget any cache already stored under that key
        cache()->forget($cacheKey);

        // Set the protected $cacheKey property on the PermissionRegistrar instance
        $registrar = app(PermissionRegistrar::class);
        $this->setRegistrarCacheKey($registrar, $cacheKey);

        // Force reload of permissions for the current (new) cache key
        $registrar->forgetCachedPermissions();
    }

    public function forgetCurrent(): void
    {
        // Clear cached permissions when leaving tenant
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function setRegistrarCacheKey(PermissionRegistrar $registrar, string $key): void
    {
        $ref = new ReflectionClass($registrar);

        // try property name variants to be robust between versions
        foreach (['cacheKey', 'cache_key', 'cache'] as $prop) {
            if ($ref->hasProperty($prop)) {
                $p = $ref->getProperty($prop);
                $p->setAccessible(true);
                $p->setValue($registrar, $key);
                return;
            }
        }

        // If no property found, fall back to binding a closure that returns our key (less common)
        // but we'll still try to set the protected property above; if none found, nothing else to do.
    }
}
