<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseInfo extends Model
{
    protected $fillable = [
        'code', 'name', 'industry', 'area', 'pe', 'outstanding', 'totals', 'totalAssets', 'liquidAssets', 'fixedAssets', 'reserved', 'reservedPerShare', 'esp', 'bvps', 'pb', 'timeToMarket', 'undp', 'perundp', 'rev', 'profit', 'gpr', 'npr', 'holders',
    ];
}
