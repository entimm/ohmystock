<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateKline extends Model
{
    protected $fillable = [
        'code', 'date', 'open', 'close', 'high', 'low', 'volume', 
    ];
}
