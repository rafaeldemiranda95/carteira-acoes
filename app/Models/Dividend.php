<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dividend extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'date',
        'value',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
