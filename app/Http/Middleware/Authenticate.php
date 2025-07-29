<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // if this is a tenant route, redirect to tenant login, otherwise use main login
            if ($request->route()->hasParameter('tenant')) {
                return route('tenant.login');
            }
            return route('login');
        }
        return null;
    }

}
