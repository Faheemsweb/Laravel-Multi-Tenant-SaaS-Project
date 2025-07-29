<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantInMemory = Tenant::current();

        if (!$tenantInMemory) {
            return $next($request);
        }

        $landlordConnection = config('multitenancy.landlord_database_connection_name');

        $freshTenantData = DB::connection($landlordConnection)
            ->table('tenants')
            ->where('id', $tenantInMemory->id)
            ->first();

        if ($freshTenantData && (!property_exists($freshTenantData, 'provisioning_status') || $freshTenantData->provisioning_status !== 'active')) {
            abort(403, 'Your account is currently inactive. Please contact support.');
        }

        return $next($request);
    }
}
