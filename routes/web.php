<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController
};
use App\Http\Controllers\Clients\{
    ClientController
};
use App\Http\Controllers\Carers\{
    DetailController
};
use App\Http\Controllers\Schedules\{
    ScheduleController
};

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::match(['get', 'post'], '/', function () {
        return view('home');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');


    /*
     * Carers Routes
     */
    Route::prefix('carers')->group(function () {
        Route::prefix('details')->group(function () {
            Route::get('/', [DetailController::class, 'view'])->name('carers.details');
            Route::get('/index', [DetailController::class, 'index'])->name('carers.details.index');
            Route::post('/create', [DetailController::class, 'store'])->name('carers.details.store');
            Route::put('/{id}/update', [DetailController::class, 'update'])->name('carers.details.update');
            Route::delete('/{id}/remove', [DetailController::class, 'destroy'])->name('carers.details.destroy');

            Route::post('/upload', [DetailController::class, 'upload'])->name('carers.details.upload'); // image upload
            // image
        });
    });

    /*
     * Carers Routes
     */
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'view'])->name('schedules');
        Route::get('/index', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/visits', [ScheduleController::class, 'visits'])->name('schedules.visits');
        Route::put('/view/{id}', [ScheduleController::class, 'show'])->name('schedules.view');
        //Route::delete('/{id}/remove', [ScheduleController::class, 'destroy'])->name('carers.details.destroy');

    });

    /*
     * Carers Routes
     */
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'view'])->name('schedules');
        Route::get('/index', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/visits', [ScheduleController::class, 'visits'])->name('schedules.visits');
        Route::put('/view/{id}', [ScheduleController::class, 'show'])->name('schedules.view');
        //Route::delete('/{id}/remove', [ScheduleController::class, 'destroy'])->name('carers.details.destroy');

    });

    /*
     * Clients Routes
     */
    Route::prefix('clients')->group(function() {
            Route::get('/', [ClientController::class, 'view'])->name('clients');
            Route::get('/index', [ClientController::class, 'index'])->name('clients.index');
            Route::post('/create', [ClientController::class, 'store'])->name('clients.store');
            Route::put('/update/{id}', [ClientController::class, 'update'])->name('clients.update');
            Route::delete('/{id}/remove', [ClientController::class, 'destroy'])->name('clients.destroy');

            Route::post('/upload', [ClientController::class, 'upload'])->name('clients.upload'); // image upload
       
    });
    
});
