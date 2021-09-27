<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ClientController
};
use App\Http\Controllers\Carers\{
    DetailController
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

Route::group(['middleware' => 'auth'], function() {
    Route::match(['get', 'post'], '/', function () {
        return view('home');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');


    /*
     * Carers Routes
     */
    Route::prefix('carers')->group(function() {
        Route::prefix('details')->group(function() {
            Route::get('/', [DetailController::class, 'view'])->name('carers.details');
            Route::get('/index', [DetailController::class, 'index'])->name('carers.details.index');
            Route::post('/create', [DetailController::class, 'store'])->name('carers.details.store');
            Route::put('/{id}/update', [DetailController::class, 'update'])->name('carers.details.update');
            Route::delete('/{id}/remove', [DetailController::class, 'destroy'])->name('carers.details.destroy');
        });
    });

    /*
     * Clients Routes
     */
    Route::prefix('clients')->group(function() {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/create', [ClientController::class, 'store'])->name('clients.store');
        Route::put('/update/{id}', [ClientController::class, 'update'])->name('clients.update');
    });
});
