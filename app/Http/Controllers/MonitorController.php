<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonitorController extends Controller
{
    public function charts(Request $request)
    {
        $param['group'] = $request->group;
        $param['date'] = $request->date;
        return view('monitor', compact('param'));
    }

    public function list(Request $request)
    {
        $monitors = Monitor::where(['going' => true])
            ->whereNotIn('group', config('stock.dayli_groups'))
            ->join('base_infos', 'monitors.code', '=', 'base_infos.code')
            ->select('name', 'monitors.*')
            ->orderBy('start')->get()->groupBy('group')
            ->all();

        $param['group'] = $request->group;
        $param['date'] = $request->date;
        return view('list', compact('param', 'monitors'));
    }

    public function daily_list(Request $request)
    {
        $monitors = Monitor::where(['going' => true])
            ->where(['group' => isset($request->group) ? $request->group : 1])
            ->join('base_infos', 'monitors.code', '=', 'base_infos.code')
            ->select('name', 'monitors.*')
            ->orderBy('start')->get()->groupBy('start')
            ->all();
        $param['group'] = $request->group;
        $param['date'] = $request->date;
        return view('daily_list', compact('param', 'monitors'));
    }

    public function add()
    {
        return view('add');
    }

    public function store(Request $request)
    {
        $codes = array_filter(preg_split('/[,\s]/', $request->codes));
        foreach ($codes as $code) {
            Monitor::firstOrCreate(['code' => $code, 'group' => $request->group], ['start' => $request->start ?: date('Y-m-d')]);
        }
        return redirect('list');
    }
}