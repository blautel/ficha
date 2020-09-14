<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

// Grupo para acceso "admin"
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
        'can:gest-proyectos',
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('proyecto', 'ProyectoCrudController');
    Route::crud('tarea', 'TareaCrudController');
});

// Grupo para acceso normal
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    Route::crud('jornada', 'JornadaCrudController');
    Route::get('/api/tarea', 'TareaApiController@index');
    Route::get('/api/tarea/{id}', 'TareaApiController@show');
}); // this should be the absolute last line of this file
