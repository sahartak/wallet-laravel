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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'user']], function () {
    Route::resource('user', 'UserController');
    Route::resource('category', 'CategoryController');
    Route::resource('transaction', 'TransactionController');
    Route::get('transactions-chart', 'TransactionController@transactionChart')->name('transactions-chart');
});
Route::group(['middleware' => ['auth','admin']], function () {
    Route::resource('/admin/users', 'Admin\UserController');
});
