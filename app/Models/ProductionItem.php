<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id',
        'yarn_material_id',
        'planned_quantity',
        'actual_quantity',
    ];

    public function order()
    {
        return $this->belongsTo(ProductionOrder::class, 'production_order_id');
    }

    public function yarnMaterial()
    {
        return $this->belongsTo(YarnMaterial::class, 'yarn_material_id');
    }
}
