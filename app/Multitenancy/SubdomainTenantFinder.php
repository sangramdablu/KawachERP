<?php

namespace App\Multitenancy;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;
use App\Models\Tenant;

class SubdomainTenantFinder extends TenantFinder
{
    /**
     * Spatie requires this exact method signature.
     */
    public function findForRequest(Request $request): ?IsTenant
    {
        $host = $request->getHost(); // e.g. school1.kawach.test
        $parts = explode('.', $host);
        $subdomain = $parts[0];      // school1

        // Skip main domain
        if (in_array($subdomain, ['www', 'kawach', 'test'])) {
            return null;
        }

        return Tenant::where('slugs', $subdomain)->first();
    }
}
