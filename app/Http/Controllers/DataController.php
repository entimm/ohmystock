<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function realtime_price($codes)
    {
        $columns = [
            'name' => '股票名字',
            'open' => '今日开盘价',
            'last_close' => '昨日收盘价',
            'price' => '当前价格',
            'high' => '今日最高价',
            'low' => '今日最低价',
            'bid_buy_price' => '竞买价',
            'bid_sell_price' => '竞卖价',
            'total_volume' => '成交的股票数',
            'total_amount' => '成交金额',
            'buy1_num' => '买一股数',
            'buy1_price' => '买一报价',
            'buy2_num' => '买二股数',
            'buy2_price' => '买二报价',
            'buy3_num' => '买三股数',
            'buy3_price' => '买三报价',
            'buy4_num' => '买四股数',
            'buy4_price' => '买四报价',
            'buy5_num' => '买五股数',
            'buy5_price' => '买五报价',
            'sell1_num' => '卖一股数',
            'sell1_price' => '卖一报价',
            'sell2_num' => '卖二股数',
            'sell2_price' => '卖二报价',
            'sell3_num' => '卖三股数',
            'sell3_price' => '卖三报价',
            'sell4_num' => '卖四股数',
            'sell4_price' => '卖四报价',
            'sell5_num' => '卖五股数',
            'sell5_price' => '卖五报价',
            'date' => '日期',
            'time' => '时间',
        ];

        $codes = array_map(function($code) {
            return (starts_with($code, '60') ? 'sh' : 'sz') . $code;
        }, explode(',', $codes));
        $content = (new Client)->get('http://hq.sinajs.cn/list=' . implode(',', $codes))->getBody();
        $content = iconv('gb2312', 'utf8', $content);
        $collection = collect();
        foreach (array_filter(explode(PHP_EOL, $content)) as $line) {
            $line = explode('"', $line)[1];
            $values = explode(',', $line);
            array_pop($values);
            $arr = array_combine(array_keys($columns), $values);
            $arr['percent'] = number_format(($arr['price']/$arr['last_close'] - 1) * 100, 2);
            $collection->push(collect($arr)->only('name', 'price', 'percent', 'time'));
        }
        return $collection;
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