<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'production_order_id',
        'machine_name',
        'production_date',
        'notes',
        'status',
        'approved_by',
        'rejection_note',
    ];

    protected $casts = [
        'production_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductionReportDetail::class);
    }
}
