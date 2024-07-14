<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/addChat',
        [\App\Http\Controllers\ChatsController::class, 'showAddNewChat']
    )->name('addChat');
    Route::get('/chat',
        [\App\Http\Controllers\ChatsController::class, 'showChat']
    )->name('chat');
    Route::post('/checkChat',
        [\App\Http\Controllers\ChatsController::class, 'checkChat']
    )->name('checkChat');
//    Route::post('/chat',
//        [\App\Http\Controllers\ChatsController::class, 'createChat']
//    )->name('createChat');
});
