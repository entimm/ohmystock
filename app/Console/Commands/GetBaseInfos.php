<?php

namespace App\Console\Commands;

use App\Models\BaseInfo;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GetBaseInfos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:base_infos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取沪深上市公司基本情况';

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
        $process = new Process(['python3', './python/get_stock_basics.py']);
        $process->mustRun();
        $arr = json_decode($process->getOutput(), true);

        foreach ($arr as $key => $item) {
            BaseInfo::updateOrCreate(['code' => $key], $item);
        }
        $this->info('update base infos done!');
    }
}
