<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

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
    /*return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);*/

    $apiURL = 'https://postulaciones.solutoria.cl/api/acceso';
    // POST Data
    $postInput = [
        "userName"=> "sebastiancordova4_hcb@indeedemail.com",
        "flagJson"=> true
    ];
    // Headers
    $headers = [
        "Content-Type"=>"application/json"
    ];
    $response = Http::withHeaders($headers)->post($apiURL, $postInput);
    $statusCode = $response->status();
    $responseBody = json_decode($response->getBody(), true);

   // print_r($responseBody["token"]); // body response

    echo  $apiURL = 'https://postulaciones.solutoria.cl/api/indicadores';
    // Headers
    $headers = [
        "Content-Type"=>"application/json",
        'Authorization'=>'Bearer '.$responseBody["token"]
    ];
    $response = Http::withHeaders($headers)->get($apiURL);
    $statusCode = $response->status();
    $responseBody = json_decode($response->getBody(), true);
    echo "<pre>";
    print_r($responseBody);
    echo "</pre>";


});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
