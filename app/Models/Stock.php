<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'short_name',
        'type',
        'currency',
        'price',
        'change',
        'change_percent',
        'day_high',
        'day_low',
        'day_open',
        'volume',
        'previous_close',
        'pe_ratio',
        'eps',
        'logo_url',
        'fifty_two_week_range',
        'fifty_two_week_low',
        'fifty_two_week_high',
        'close', 
        'sector', 
        'market_cap', 
        'description', 
    ];

    public function dividends()
    {
        return $this->hasMany(Dividend::class);
    }
}
