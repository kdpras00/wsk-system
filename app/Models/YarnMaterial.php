<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YarnMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'type',
        'batch_number',
        'stock_quantity',
        'unit',
    ];
}
