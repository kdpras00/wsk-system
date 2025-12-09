<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_report_id',
        'shift_name',
        'counter_start',
        'counter_end',
        'pcs_count',
        'kg_count',
        'meter_count',
        'operator_name',
        'comment',
        'yarn_material_id',
        'usage_qty',
    ];

    public function yarn(): BelongsTo
    {
        return $this->belongsTo(YarnMaterial::class, 'yarn_material_id');
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(ProductionReport::class, 'production_report_id');
    }
}
