<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/', 'TaskController');
Route::delete('/delete/{id?}', 'TaskController@destroy');
Route::post('/comp/{id}', 'TaskController@comp');
Route::post('/edit/{id}', 'TaskController@edit');
Route::get('/edit/{id}', 'TaskController@edit');
Route::post('/update/{id}', 'TaskController@update');
Route::get('/comp_tasks', 'TaskController@comp_tasks');
Route::post('/select_delete', 'TaskController@select_delete');

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/auth', 'AuthController@authUser');
Route::get('/auth_check', 'AuthController@authCheck');
Route::get('/tasks', 'AuthController@tasks');
Route::post('/tasks', 'AuthController@tasks');