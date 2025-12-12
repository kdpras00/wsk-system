<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    use HasFactory;
    protected $fillable = [
        'pattern',
        'meter',
        'jam',
        'no_pcs',
        'stok_kg',
        'keterangan',
        'yarn_material_id',
    ];
    //
}
