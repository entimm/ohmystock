<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('get_realtime_price {codes?*}', function () {
    $columns = ['name', 'open', 'preclose', 'price', 'high', 'low', 'total_volume', 'total_amount', 'date', 'time',];
    $codes = $this->argument('codes');
    $collection = realtime_price($codes);
    $this->table($columns, $collection->map->only($columns));
})->describe('get realtime stock price');
