<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Multitenancy\Models\Tenant;

class StoreTenantInSession
{
    public function handle($request, Closure $next)
    {
        $tenant = Tenant::current();

        if ($tenant) {
            session([
                'tenant_id' => $tenant->id,
                'tenant_name' => $tenant->school_name,
            ]);
        }

        return $next($request);
    }
}
