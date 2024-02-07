<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard1');
    });

    Route::get('/analytics', function () {
        return view('analytics');
    });

    Route::get('/mymap', function () {
        return view('map');
    });

    Route::post('/onrel',function(){
        $message = 'onrel';
        event(new App\Events\DeviceControl($message));
        return redirect('dashboard');
    });
    Route::post('/offrel',function(){
        $message = 'offrel';
        event(new App\Events\DeviceControl($message));
        return redirect('dashboard');
    });

    Route::get('/route/levelroute','App\Http\Controllers\dbcontroller@getlevel');
    Route::get('/route/flowroute','App\Http\Controllers\dbcontroller@getflow');
    Route::get('/route/vibrateroute','App\Http\Controllers\dbcontroller@getvibration');
    Route::get('/route/alarmstatroute','App\Http\Controllers\dbcontroller@getalarmstat');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');