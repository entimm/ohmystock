<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function realtime_price($codes = '')
    {
        $codes = array_filter(explode(',', $codes));
        return realtime_price($codes);
    }

    public function k_data($code)
    {
        $process = new Process(['python3', '../python/get_k_data.py', $code]);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }

    public function realtime_quotes($code)
    {
        $process = new Process(['python3', '../python/get_realtime_quotes.py', $code]);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }

    public function tick_data($code, $date = null)
    {
        $date = $date ?: date('Y-m-d');
        $process = new Process(['python3', '../python/get_tick_data.py', $code, $date]);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }

    public function today_ticks($code)
    {
        $process = new Process(['python3', '../python/get_today_ticks.py', $code]);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }

    public function index()
    {
        $process = new Process(['python3', '../python/get_index.py']);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }

    public function today_all()
    {
        $process = new Process(['python3', '../python/get_today_all.py']);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }

    public function stock_basics()
    {
        $process = new Process(['python3', '../python/get_stock_basics.py']);
        $process->mustRun();

        return response() ->json(json_decode($process->getOutput()));
    }
}