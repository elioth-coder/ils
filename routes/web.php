<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store'])->name('login');
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/settings', function () {
        return view('dashboard.settings');
    });

    Route::get('/collections', function () {
        return view('dashboard.collections');
    });

    Route::get('/patrons', function () {
        return view('dashboard.patrons');
    });

    Route::prefix('patrons/students')->group(function () {
        Route::controller(StudentController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('collections/books')->group(function () {
        Route::controller(BookController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::get('/{id}/copy', 'copy');
            Route::put('/{id}', 'duplicate');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('settings/libraries')->group(function () {
        Route::controller(LibraryController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('settings/campuses')->group(function () {
        Route::controller(CampusController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('settings/colleges')->group(function () {
        Route::controller(CollegeController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('settings/programs')->group(function () {
        Route::controller(ProgramController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
});
