<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Redirect by role
        $middleware->redirectUsersTo(function (Request $request) {
            $user = $request->user();
            return match ($user->role) {
                'admin'   => '/admin/dashboard',
                'dokter'  => '/doctor/dashboard',
                'pasien'  => '/patient/dashboard',
                default   => '/dashboard',
            };
        });

        // ✅ REGISTER ALIAS MIDDLEWARE "role"
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
