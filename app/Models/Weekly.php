<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekly extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_status_id',
        'quantity',
        'part_number',
        'brand',
        'gross_profit',
        'state',
        'single_bulk',
    ];

    public function weeklyRep(){
        
    }

}