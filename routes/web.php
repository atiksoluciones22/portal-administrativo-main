<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemographicReportController;
use App\Http\Controllers\{DashboardController, SettingController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::redirect('/', '/login');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/ubicacion-de-trabajador', [DashboardController::class, 'workerLocation'])->name('workerLocation');
        Route::get('/tipografia', [DashboardController::class, 'typography'])->name('typography');
    });

    Route::prefix('reportes-demograficos')->name('demographic-reports.')->group(function () {
        Route::get('/sexo', [DemographicReportController::class, 'sex'])->name('sex');
        Route::get('/edad', [DemographicReportController::class, 'age'])->name('age');
        Route::get('/nacionalidad', [DemographicReportController::class, 'nationality'])->name('nationality');
        Route::get('/antiguedad', [DemographicReportController::class, 'antique'])->name('antique');
        Route::get('/absentismo', [DemographicReportController::class, 'absentism'])->name('absentism');
    });
});
