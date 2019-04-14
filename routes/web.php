<?php

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

Route::get('/', 'MonitorController@charts');
Route::get('/monitor', 'MonitorController@charts');
Route::get('/list', 'MonitorController@list');
Route::get('/daily_list', 'MonitorController@daily_list');
Route::get('/add', 'MonitorController@add');
Route::post('/store', 'MonitorController@store');

Route::get('/get_realtime_price/{codes?}', 'DataController@realtime_price');

Route::get('/get_k_data/{code}', 'DataController@k_data');
Route::get('/get_realtime_quotes/{code}', 'DataController@realtime_quotes');
Route::get('/get_tick_data/{code}/{date?}', 'DataController@tick_data');
Route::get('/get_today_ticks/{code}', 'DataController@today_ticks');
Route::get('/get_index', 'DataController@index');
Route::get('/get_today_all', 'DataController@today_all');
Route::get('/get_stock_basics', 'DataController@stock_basics');