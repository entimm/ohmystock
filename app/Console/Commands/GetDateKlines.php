<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;
use App\Models\Monitor;
use App\Models\DateKline;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GetDateKlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:date_klines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取个股历史交易数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arr = Monitor::where(['going' => true])->pluck('start', 'code')->all();

        $last_dates = DateKline::select(['code', DB::raw('max(date) last_date')])
            ->whereIn('code', array_keys($arr))
            ->groupBy('code')
            ->get()
            ->pluck('last_date', 'code')
            ->toArray();

        foreach ($arr as $code =>$start) {
            $start = $last_dates[$code] ?? $start;
            $process = new Process(['python3', './python/get_k_data.py', $code, $start]);
            $process->mustRun();

            $dateKlines = json_decode($process->getOutput(), true);
            DB::transaction(function () use ($dateKlines) {
                foreach ($dateKlines as $dateKline) {
                    DateKline::firstOrCreate(array_only($dateKline, ['code', 'date']), $dateKline);
                }
            });
        }
    }
}
