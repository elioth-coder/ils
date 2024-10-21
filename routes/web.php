<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\MediaDiscController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Student;

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserAccountController::class, 'create']);
    Route::post('/register', [UserAccountController::class, 'store']);
    Route::get('/accounts/email_confirmation', [UserAccountController::class, 'email_confirmation']);
    Route::get('/accounts/activate/{token_value}', [UserAccountController::class, 'activate']);

    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store'])->name('login');
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::get('/dashboard', function () {
    if(in_array(Auth::user()->role, ['teacher','student'])) {
        $user = null;
        if(Auth::user()->role == 'teacher') {
            $user = Teacher::where('email', Auth::user()->email)->first();
        }
        if(Auth::user()->role == 'student') {
            $user = Student::where('email', Auth::user()->email)->first();
        }

        return view('dashboard.index', [
            'user' => $user,
        ]);
    }

    return view('dashboard.index');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/accounts/profile', [UserAccountController::class, 'profile']);
    Route::patch('/accounts/edit_profile', [UserAccountController::class, 'edit_profile']);
    Route::get('/accounts/password', [UserAccountController::class, 'password']);
    Route::post('/accounts/change_password', [UserAccountController::class, 'change_password']);

    Route::get('/settings', function () {
        return view('dashboard.settings');
    });

    Route::get('/collections', function () {
        return view('dashboard.collections');
    });

    Route::get('/users', function () {
        return view('dashboard.users');
    });

    Route::prefix('search')->group(function () {
        Route::controller(SearchController::class)->group(function () {
            Route::get('/books', 'books');
            Route::get('/books/{isbn}', 'book_copies');
        });
    });

    Route::prefix('users/teachers')->group(function () {
        Route::controller(TeacherController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('users/students')->group(function () {
        Route::controller(StudentController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('users/staffs')->group(function () {
        Route::controller(StaffController::class)->group(function () {
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
            Route::get('/{isbn}/detail', 'detail');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::get('/{id}/copy', 'copy');
            Route::put('/{id}', 'duplicate');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::prefix('collections/researches')->group(function () {
        Route::controller(ResearchController::class)->group(function () {
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

    Route::prefix('collections/media_discs')->group(function () {
        Route::controller(MediaDiscController::class)->group(function () {
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
