<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::get('/', [ClientController::class, 'index'])->name('home');

Route::get('/customers/{id}', [ClientController::class, 'show'])->name('customer.show');

Route::get('authorization', 'Auth\LoginController@authorization')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);



