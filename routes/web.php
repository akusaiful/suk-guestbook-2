<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\SignerController;
use App\Http\Controllers\SigningController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\GuestRegistrationController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});


/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');


/*
|--------------------------------------------------------------------------
| AUTH FALLBACK
|--------------------------------------------------------------------------
|
| Laravel auth middleware mencari route bernama "login"
| apabila user belum login.
|
*/

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| PUBLIC SIGN DEVICE
|--------------------------------------------------------------------------
*/

Route::get('/sign-device', [SigningController::class, 'device'])
    ->name('sign.device');

Route::post(
    '/sign-device/{session}/submit',
    [SigningController::class, 'submitSignature']
)->name('sign.submit');


/*
|--------------------------------------------------------------------------
| PUBLIC DISPLAY / TV LED
|--------------------------------------------------------------------------
*/

Route::get('/display/{event}', [DisplayController::class, 'show'])
    ->name('display.show');


/*
|--------------------------------------------------------------------------
| PUBLIC QR REGISTRATION
|--------------------------------------------------------------------------
*/

Route::get(
    '/register/{event}',
    [GuestRegistrationController::class, 'show']
)->name('guest.register');

Route::post(
    '/register/{event}',
    [GuestRegistrationController::class, 'store']
)->name('guest.register.store');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | ADMIN EVENTS
        |--------------------------------------------------------------------------
        */

        Route::resource('events', EventController::class);


        /*
        |--------------------------------------------------------------------------
        | ADMIN EVENT QR
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/events/{event}/qr',
            [EventController::class, 'qr']
        )->name('events.qr');


        /*
        |--------------------------------------------------------------------------
        | ADMIN EVENT SIGN REQUEST
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/events/{event}/signers/{signer}/request-sign',
            [SigningController::class, 'requestSign']
        )->name('events.request-sign');

        Route::post(
            '/events/{event}/clear-signature',
            [SigningController::class, 'clearSignaturePad']
        )->name('events.clear-signature');

        Route::post(
            '/events/{event}/cancel-signing',
            [SigningController::class, 'cancelSigning']
        )->name('events.cancel-signing');


        /*
        |--------------------------------------------------------------------------
        | ADMIN SIGNERS
        |--------------------------------------------------------------------------
        */

        Route::resource('signers', SignerController::class);

        Route::patch(
            '/signers/{signer}/toggle-status',
            [SignerController::class, 'toggleStatus']
        )->name('signers.toggle-status');


        /*
        |--------------------------------------------------------------------------
        | ADMIN VISITORS
        |--------------------------------------------------------------------------
        */

        Route::get('/visitors', [VisitorController::class, 'index'])
            ->name('visitors.index');

        Route::get('/visitors/create', [VisitorController::class, 'create'])
            ->name('visitors.create');

        Route::post('/visitors', [VisitorController::class, 'store'])
            ->name('visitors.store');

        Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])
            ->name('visitors.destroy');


        /*
        |--------------------------------------------------------------------------
        | ADMIN SIGNATURE HISTORY
        |--------------------------------------------------------------------------
        */

        Route::get('/signatures', [SigningController::class, 'history'])
            ->name('signatures.index');

        Route::delete(
            '/signatures/{signature}',
            [SigningController::class, 'destroySignature']
        )->name('signatures.destroy');


                /*
        |--------------------------------------------------------------------------
        | ADMIN REPORTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [ReportController::class, 'index']
        )->name('reports.index');

        Route::get(
            '/reports/export/csv',
            [ReportController::class, 'exportCsv']
        )->name('reports.export.csv');


    });