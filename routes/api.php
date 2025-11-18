<?php

declare(strict_types=1);

use App\Http\Middleware\RequireWorkspace;
use Illuminate\Support\Facades\Route;
use Sendportal\Base\Facades\Sendportal;

Route::middleware([
    config('sendportal-host.throttle_middleware'),
    RequireWorkspace::class,
])->group(function () {
    // Auth'd API routes (workspace-level auth!).
    Sendportal::apiRoutes();

    Route::put('landing-pages/{id}', 'LandingPagesController@updateContent')->name('api.landing-pages.update');
});

// Non-auth'd API routes.
Sendportal::publicApiRoutes();
