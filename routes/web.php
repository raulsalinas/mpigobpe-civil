<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CobrosController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConsistenciaDeDefuncionesController;
use App\Http\Controllers\ConsistenciaDeMatrimoniosController;
use App\Http\Controllers\ConsistenciaDeNacimientosController;
use App\Http\Controllers\ControlDeDefuncionesController;
use App\Http\Controllers\ControlDeMatrimoniosController;
use App\Http\Controllers\ControlDeNacimientosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListadoCobrosController;
use App\Http\Controllers\ListadoDeDefuncionesController;
use App\Http\Controllers\ListadoDeMatrimoniosController;
use App\Http\Controllers\ListadoDeNacimientosController;
use App\Http\Controllers\PagosController;
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
        Route::put('eliminar/{id}', [ListadoDeNacimientosController::class, 'eliminar'])->name('eliminar');

        Route::name('control.')->prefix('control')->group(function () {
            Route::get('index', [ControlDeNacimientosController::class, 'index'])->name('index');
            Route::get('visualizar/{id}', [ControlDeNacimientosController::class, 'visualizar'])->name('visualizar');
            Route::post('guardar', [ControlDeNacimientosController::class, 'guardar'])->name('guardar');
            Route::post('guardar-recibo', [ControlDeNacimientosController::class, 'guardarRecibo'])->name('guardar-recibo');
            Route::post('actualizar', [ControlDeNacimientosController::class, 'actualizar'])->name('actualizar');
            Route::post('observar', [ControlDeNacimientosController::class, 'observar'])->name('observar');
            Route::get('visualizar-adjunto', [ControlDeNacimientosController::class, 'visualizarAdjuntoNacimiento'])->name('visualizarAdjuntoNacimiento');
            Route::get('buscar-ficha/{id}/{folder}', [ControlDeNacimientosController::class, 'buscarFicha'])->name('buscar-ficha');
        });
        Route::name('consistencia.')->prefix('consistencia')->group(function () {
            Route::get('index', [ConsistenciaDeNacimientosController::class, 'index'])->name('index');
            Route::get('reporte/{ano_nac?}/{nro_lib?}/{sex_nac?}/{ubigeo?}/{usuario?}/{cen_asi?}/{fch_nac_desde?}/{fch_nac_hasta?}', [ConsistenciaDeNacimientosController::class, 'reporte'])->name('reporte');
        });
    });
    Route::name('matrimonios.')->prefix('matrimonios')->group(function () {
        Route::get('index', [ListadoDeMatrimoniosController::class, 'index'])->name('index');
        Route::post('listar', [ListadoDeMatrimoniosController::class, 'listar'])->name('listar');
        Route::name('control.')->prefix('control')->group(function () {
            Route::get('index', [ControlDeMatrimoniosController::class, 'index'])->name('index');
        });
        Route::name('consistencia.')->prefix('consistencia')->group(function () {
            Route::get('index', [ConsistenciaDeMatrimoniosController::class, 'index'])->name('index');
            Route::get('reporte/{ano_cel?}/{nro_lib?}/{usuario?}/{fch_cel_desde?}/{fch_cel_hasta?}', [ConsistenciaDeMatrimoniosController::class, 'reporte'])->name('reporte');

        });
    });
    Route::name('defunciones.')->prefix('defunciones')->group(function () {
        Route::get('index', [ListadoDeDefuncionesController::class, 'index'])->name('index');
        Route::post('listar', [ListadoDeDefuncionesController::class, 'listar'])->name('listar');
        Route::name('control.')->prefix('control')->group(function () {
            Route::get('index', [ControlDeDefuncionesController::class, 'index'])->name('index');
        });
        Route::name('consistencia.')->prefix('consistencia')->group(function () {
            Route::get('index', [ConsistenciaDeDefuncionesController::class, 'index'])->name('index');
        });
    });
    Route::name('utilidades.')->prefix('utilidades')->group(function () {
        Route::name('cobros.')->prefix('cobros')->group(function () {
            Route::get('index', [ListadoCobrosController::class, 'index'])->name('index');
            Route::post('listar', [ListadoCobrosController::class, 'listar'])->name('listar');
        });
    });
    Route::name('configuracion.')->prefix('configuracion')->group(function () {
        Route::get('gestionar-usuarios', [ConfiguracionController::class, 'gestionarUsuariosIndex'])->name('gestionar-usuarios-index');
        Route::post('listar-usuarios', [ConfiguracionController::class, 'listarUsuarios'])->name('listar-usuarios');
        Route::post('listar-ubigeo', [ConfiguracionController::class, 'listarUbigeo'])->name('listar-ubigeo');
        Route::get('maestros', [ConfiguracionController::class, 'maestrosIndex'])->name('maestros-index');

    });
});
