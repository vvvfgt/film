<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/film')
    ->controller(FilmController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')
            ->whereNumber('id');
        Route::put('/{id}', 'update')
            ->whereNumber('id');
        Route::post('/', 'store');
        Route::delete('/{id}', 'destroy')
            ->whereNumber('id');
        Route::patch('/set-status', 'setPublishStatus');
        Route::get('/genre-films/{id}', 'genreFilms');
    });

Route::prefix('/genre')
    ->controller(GenreController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update')
            ->whereNumber('id');
        Route::delete('/{id}', 'destroy')
            ->whereNumber('id');
    });
