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

use Symfony\Component\Process\Process;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/monitor', function (Request $request) {
    $param['group'] = $request->group;
    $param['date'] = $request->date;
    return view('monitor', compact('param'));
});

Route::get('/chartjs', function () {
    return view('chartjs');
});

Route::get('/get_k_data', function () {
    $process = new Process(['python3', '../python/get_k_data.py', '000725']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});

Route::get('/get_realtime_quotes', function () {
    $process = new Process(['python3', '../python/get_realtime_quotes.py', '000725']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});

Route::get('/get_tick_data', function () {
    $process = new Process(['python3', '../python/get_tick_data.py', '000725', '2018-05-02']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});

Route::get('/get_today_ticks', function () {
    $process = new Process(['python3', '../python/get_today_ticks.py', '000725']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});

Route::get('/get_index', function () {
    $process = new Process(['python3', '../python/get_index.py']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});

Route::get('/get_today_all', function () {
    $process = new Process(['python3', '../python/get_today_all.py']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});

Route::get('/get_stock_basics', function () {
    $process = new Process(['python3', '../python/get_stock_basics.py']);
    $process->mustRun();

    return response() ->json(json_decode($process->getOutput()));
});