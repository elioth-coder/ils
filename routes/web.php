<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MediaDiscController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CurrentLoanController;
use App\Http\Controllers\ItemRequestController;
use App\Http\Controllers\PatronController;
use App\Models\RequestedItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\Student;

Route::get('/test', function () {
    $pdo = DB::connection()->getPdo();
    $query = $pdo->prepare('SELECT * FROM books');
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

    dd($results);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AccountController::class, 'create']);
    Route::post('/account', [AccountController::class, 'store']);
    Route::get('/account/email_confirmation', [AccountController::class, 'email_confirmation']);
    Route::get('/account/activate/{token_value}', [AccountController::class, 'activate']);

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

    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/account/edit', [AccountController::class, 'edit']);
    Route::patch('/account/update', [AccountController::class, 'update']);
    Route::get('/account/change_password', [AccountController::class, 'change_password']);
    Route::post('/account/update_password', [AccountController::class, 'update_password']);

    Route::prefix('services/checkouts')->group(function () {
        Route::controller(CheckoutController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/find_barcode', 'find_barcode');
            Route::post('/reserve_item', 'reserve_item');
            Route::post('/checkout_item', 'checkout_item');
            Route::post('/cancel_item', 'cancel_item');
            Route::post('/return_item', 'return_item');
            Route::post('/renew_item', 'renew_item');
            Route::get('/{card_number}/patron', 'patron');
        });
    });

    Route::prefix('services/item_requests')->group(function () {
        Route::controller(ItemRequestController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('services/current_loans')->group(function () {
        Route::controller(CurrentLoanController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('services/patrons')->group(function () {
        Route::controller(PatronController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::get('/settings', function () {
        return view('dashboard.settings');
    });

    Route::get('/collections', function () {
        return view('dashboard.collections');
    });

    Route::get('/users', function () {
        return view('dashboard.users');
    });

    Route::get('/services', function () {
        return view('dashboard.services');
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
            Route::post('/request', 'request');
            Route::post('/cancel_request', 'cancel_request');
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
