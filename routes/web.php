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

Route::get('/import-du-lieu', "TransactionController@importView");
Route::post('/import-transaction', "TransactionController@import");
Route::post('/add-transaction', "TransactionController@save");
Route::get('/du-lieu-giao-dich', "TransactionController@index");
Route::get('/chuan-hoa-giao-dich', "TransactionController@stdTransactions");
Route::get('/them-giao-dich', "TransactionController@add");
Route::get('/chi-tiet-giao-dich/{id}', "TransactionController@detail");
