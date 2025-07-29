<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Spatie\Multitenancy\Exceptions\TenantCouldNotBeIdentifiedByDomain;
use Spatie\Multitenancy\Exceptions\NoCurrentTenant;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->group('tenant', [
            \App\Http\Middleware\CheckTenantStatus::class,
            \App\Http\Middleware\PreventAccessFromCentralDomains::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NoCurrentTenant|TenantCouldNotBeIdentifiedByDomain $e, Request $request) {
            // Ensure the view exists to prevent ViewNotFoundException
            if (view()->exists('errors.tenant-not-found')) {
                return response()->view('errors.tenant-not-found', [], 404);
            }

            return response('Store not found', 404);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            return response()->view('errors.403', [], 403);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            $tenant = $request->route('tenant');
            if (!empty($tenant)) {
                return redirect()->route('tenant.login', [
                    'tenant' => $tenant
                ]);
            }

            return redirect()->guest(route('login'));
        });

    })->create();
