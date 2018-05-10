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

use App\Models\Monitor;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

Route::get('/', function () {
    return redirect('monitor');
});

Route::get('/monitor', function (Request $request) {
    $param['group'] = $request->group;
    $param['date'] = $request->date;
    return view('monitor', compact('param'));
});

Route::get('/list', function (Request $request) {
    $monitors = Monitor::where(['going' => true])
        ->whereNotIn('group', config('stock.dayli_groups'))
        ->join('base_infos', 'monitors.code', '=', 'base_infos.code')
        ->select('name', 'monitors.*')
        ->orderBy('start')->get()->groupBy('group')
        ->all();

    $param['group'] = $request->group;
    $param['date'] = $request->date;
    return view('list', compact('param', 'monitors'));
});

Route::get('/daily_list', function (Request $request) {
    $monitors = Monitor::where(['going' => true])
        ->where(['group' => isset($request->group) ? $request->group : 1])
        ->join('base_infos', 'monitors.code', '=', 'base_infos.code')
        ->select('name', 'monitors.*')
        ->orderBy('start')->get()->groupBy('start')
        ->all();
    $param['group'] = $request->group;
    $param['date'] = $request->date;
    return view('daily_list', compact('param', 'monitors'));
});

Route::get('/add', function (Request $request) {
    $param['group'] = $request->group;
    $param['date'] = $request->date;
    return view('add', compact('param'));
});

Route::post('/store', function (Request $request) {
    $codes = preg_split('/[,\s]/', $request->codes);
    foreach ($codes as $code) {
        Monitor::firstOrCreate(['code' => $code, 'group' => $request->group], ['start' => $request->start ?: date('Y-m-d')]);
    }
    return redirect('list');
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