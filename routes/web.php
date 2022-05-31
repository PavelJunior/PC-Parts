<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PcController;
use App\Http\Controllers\AccountController;


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

Route::group(['prefix' => '/parts'], function () {
    Route::get('/', [PartController::class, 'ShowAll']);
    Route::get('create', [PartController::class, 'CreatePage']);
    Route::post('create', [PartController::class, 'CreatePageSubmit']);
    Route::get('edit/{id}', [PartController::class, 'EditPage'])
        ->where('id', '[0-9]+');
    Route::post('edit/{id}', [PartController::class, 'EditPageSubmit'])
        ->where('id', '[0-9]+');
    Route::post('/{id}', [PartController::class, 'UpdateStatus'])->where('id', '[0-9]+');
});

Route::group(['prefix' => '/pcs'], function () {
    Route::get('/', [PcController::class, 'ShowAll']);
    Route::get('create', [PcController::class, 'CreatePage']);
    Route::post('create', [PcController::class, 'CreatePageSubmit']);
    Route::get('edit/{id}', [PcController::class, 'EditPage'])
        ->where('id', '[0-9]+');
    Route::post('edit/{id}', [PcController::class, 'EditPageSubmit'])
        ->where('id', '[0-9]+');
    Route::post('/{id}', [PcController::class, 'UpdateStatus'])->where('id', '[0-9]+');
});

Route::post('/contact', [ContactController::class, 'SendContactInfo']);

Route::get('/account', [AccountController::class, 'ShowAll'])->name('account');

Route::get('/', function () {
    return view('layouts.app', [
        'page' => 'home',
    ]);
})->name('home');


require __DIR__.'/auth.php';
