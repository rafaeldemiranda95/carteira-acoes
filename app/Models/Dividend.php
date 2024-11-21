<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dividend extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'asset_issued',
        'payment_date',
        'rate',
        'related_to',
        'approved_on',
        'isin_code',
        'label',
        'last_date_prior',
        'remarks',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
