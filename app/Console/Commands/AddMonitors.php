<?php

namespace App\Console\Commands;

use App\Models\Monitor;
use Illuminate\Console\Command;

class AddMonitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:monitors {codes*} {--g|group=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新增观察的股票';

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
        $codes = $this->argument('codes');
        $groupSelect = config('stock.groups');
        if (!$group = $this->option('group')) {
            $group = array_search($this->choice('选择分组：', $groupSelect, 1), $groupSelect);
        }
        foreach ($codes as $code) {
            Monitor::firstOrCreate(['code' => $code, 'group' => $group], ['start' => date('Y-m-d')]);
        }
    }
}
