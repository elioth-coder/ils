<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BackupDatabaseController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CurrentLoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemRequestController;
use App\Http\Controllers\LibrarySectionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportItemController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\IsLibrarian;
use Illuminate\Support\Facades\Route;

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AccountController::class, 'create']);
    Route::post('/account', [AccountController::class, 'store']);
    Route::get('/account/email_confirmation', [AccountController::class, 'email_confirmation']);
    Route::get('/account/activate/{token_value}', [AccountController::class, 'activate']);

    Route::get('/', [GuestController::class, 'index']);
    Route::get('/about', [GuestController::class, 'about']);
    Route::get('/resources', [GuestController::class, 'resources']);
    Route::get('/rules', [GuestController::class, 'rules']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store'])->name('login');
});

Route::prefix('search')->group(function () {
    Route::controller(SearchController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{type}', 'index');
    });
});

Route::prefix('services/attendance')->group(function () {
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/find_barcode', 'find_barcode');
        Route::post('/record', 'record');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('sections')->group(function () {
        Route::controller(LibrarySectionController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{section}', 'section');
        });
    });

    Route::prefix('dashboard')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('account')->group(function () {
        Route::controller(AccountController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/edit', 'edit');
            Route::patch('/update', 'update');
            Route::get('/change_password', 'change_password');
            Route::post('/update_password', 'update_password');
            Route::get('/change_pin', 'change_pin');
            Route::post('/update_pin', 'update_pin');
        });
    });

    Route::prefix('users')->group(function () {
        Route::controller(PatronController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/visited', 'visited');
        });
    });

    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->middleware(IsLibrarian::class);

    Route::get('/services', function () {
        return view('dashboard.services');
    })->middleware(IsLibrarian::class);

    Route::prefix('collections')->group(function () {
        Route::controller(CollectionController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/new', 'new');
            Route::get('/new/{type}', 'new_with_type');
        });
    });

    Route::prefix('notifications')->group(function () {
        Route::controller(NotificationController::class)->group(function () {
            Route::get('/library_services', 'library_services');
        });
    });

    Route::prefix('collections/items')->group(function () {
        Route::controller(ItemController::class)->group(function () {
            Route::post('/request', 'request');
            Route::post('/cancel_request', 'cancel_request');
            Route::get('/{title}/detail', 'detail');
            Route::get('/{title}/copy/{barcode}', 'barcode');

            Route::post('/set_status', 'set_status')->middleware(IsLibrarian::class);
        });
    });

    Route::middleware([IsLibrarian::class])->group(function () {

        Route::prefix('tools')->group(function () {
            Route::controller(ToolController::class)->group(function () {
                Route::get('/barcode_maker', 'barcode_maker');
                Route::get('/barcode_maker/print', 'barcode_print');
            });

            Route::controller(BackupDatabaseController::class)->group(function () {
                Route::get('/backup_db', 'index');
                Route::post('/backup_db/generate', 'generate');
                Route::post('/backup_db/delete', 'destroy');
                Route::post('/backup_db/restore', 'restore');
            });
        });

        Route::prefix('services/checkouts')->group(function () {
            Route::controller(CheckoutController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/find_barcode', 'find_barcode');
                Route::post('/reserve_item', 'reserve_item');
                Route::post('/checkout_item', 'checkout_item');
                Route::post('/cancel_item', 'cancel_item');
                Route::post('/return_item', 'return_item');
                Route::post('/renew_item', 'renew_item');
                Route::post('/notify_overdue', 'notify_overdue');
                Route::post('/notify_pickup', 'notify_pickup');
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

        Route::prefix('services/report_item')->group(function () {
            Route::controller(ReportItemController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{id}', 'create');
                Route::post('/{id}', 'store');
            });
        });

        Route::prefix('services/patrons')->group(function () {
            Route::controller(PatronController::class)->group(function () {
                Route::get('/', 'services');
            });
        });

        Route::prefix('reports')->group(function () {
            Route::controller(ReportController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/item_list', 'item_list');
                Route::get('/item_count', 'item_count');
                Route::get('/patron_list', 'patron_list');
                Route::get('/attendance_list', 'attendance_list');
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

        Route::prefix('collections/book')->group(function () {
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

        Route::prefix('collections/research')->group(function () {
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

        Route::prefix('collections/audio')->group(function () {
            Route::controller(AudioController::class)->group(function () {
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

        Route::prefix('collections/video')->group(function () {
            Route::controller(VideoController::class)->group(function () {
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
});
