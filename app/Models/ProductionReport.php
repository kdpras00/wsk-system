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
        'machine_name',
        'production_date',
        'notes',
    ];

    protected $casts = [
        'production_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductionReportDetail::class);
    }
}
