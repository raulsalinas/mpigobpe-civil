<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConcistenciaDeNacimientosController;
use App\Http\Controllers\ControlDeNacimientosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListadoDeNacimientosController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('artisan', function () {
    Artisan::call('clear-compiled');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});

Auth::routes();
Route::view('/', 'auth.login');

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('inicio', [HomeController::class, 'index'])->name('inicio');
    Route::get('total-nacimientos', [HomeController::class, 'totalNacimientos'])->name('totalNacimientos');
    Route::get('total-matrimonios', [HomeController::class, 'totalMatrimonios'])->name('totalMatrimonios');
    Route::get('total-defunciones', [HomeController::class, 'totalDefunciones'])->name('totalDefunciones');


    Route::name('nacimientos.')->prefix('nacimientos')->group(function () {
                Route::get('index', [ListadoDeNacimientosController::class, 'index'])->name('index');
                Route::post('listar', [ListadoDeNacimientosController::class, 'listar'])->name('listar');
                // Route::get('editar/anio/{anio}/libro/{libro}/folio/{folio}', [ListadoDeNacimientosController::class, 'editar'])->name('editar');
                Route::get('editar/{anio}/{libro}/{folio}', [ListadoDeNacimientosController::class, 'editar'])->name('editar');
                Route::put('eliminar/{id}', [ListadoDeNacimientosController::class, 'eliminar'])->name('eliminar');

                Route::name('control.')->prefix('control')->group(function () {
                    Route::get('index', [ControlDeNacimientosController::class, 'index'])->name('index');
                    Route::post('ver', [ControlDeNacimientosController::class, 'ver'])->name('ver');
                    Route::get('ver-acta-adverso', [ControlDeNacimientosController::class, 'verActaAdverso'])->name('verActaAdverso');
                    Route::get('ver-acta-reverso', [ControlDeNacimientosController::class, 'verActaReverso'])->name('verActaReverso');
                });
                Route::name('consistencia.')->prefix('consistencia')->group(function () {
                    Route::get('index', [ConcistenciaDeNacimientosController::class, 'index'])->name('index');
                });
        });
    Route::name('matrimonios.')->prefix('matrimonios')->group(function () {
                Route::get('index', [MatrimonioController::class, 'index'])->name('index');
                Route::post('listar', [MatrimonioController::class, 'listar'])->name('listar');
                Route::get('editar/{anio}/{libro}/{folio}', [MatrimonioController::class, 'editar'])->name('editar');
                Route::put('eliminar/{id}', [MatrimonioController::class, 'eliminar'])->name('eliminar');
        });
        Route::name('configuracion.')->prefix('configuracion')->group(function () {
        });
});