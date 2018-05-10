<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use App\Models\DateKline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DateKlineCollection;

class ApiController extends Controller
{
    public function dateKlines(Request $request)
    {
        $monitors = Monitor::where(['group' => $request->group ?: 0])
            ->where(['going' => true])
            ->when(in_array($request->group, config('stock.dayli_groups')) && $request->date, function($query) use ($request) {
                return $query->where(['start' => $request->group]);
            })->get();

        $collect = collect();
        foreach ($monitors as $item) {
            $collect = $collect->merge(DateKline::where(['code' => $item->code])->where('date', '>=', $item->start)->get());
        }

        return new DateKlineCollection($collect);
    }

    public function remove(Request $request) {
        $monitor = Monitor::find($request->id);
        $monitor->end = date('Y-m-d');
        $monitor->going = false;
        $monitor->save();
    }
}
