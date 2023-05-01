<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\indicadorController;
use App\Http\Controllers\GraficoController;

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

Route::get('/', function () {
    return Redirect::route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->name('dashboard');
    Route::get('/indicadores', [indicadorController::class,'getIndicador'])->name('indicadores');
    Route::get('/get-indicadores/{page}', [indicadorController::class,'getIndicadoresLocal']);
    Route::resource('indicador', indicadorController::class);
    Route::get('/grafico', function () {return Inertia::render('Grafico');})->name('grafico');
    Route::post('get-pick-uf', [GraficoController::class,'getData']);
});
