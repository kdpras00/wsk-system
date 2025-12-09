<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'manager_id',
        'target_quantity',
        'produced_quantity',
        'status',
        'start_date',
        'end_date',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function items()
    {
        return $this->hasMany(ProductionItem::class);
    }

    public function productionReports()
    {
        return $this->hasMany(ProductionReport::class);
    }
}
