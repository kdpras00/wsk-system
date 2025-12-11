<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FabricController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yarns = \App\Models\YarnMaterial::all();
        return view('fabrics.create', compact('yarns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pattern' => 'required|string|max:255',
            'meter' => 'required|numeric|min:0',
            'jam' => 'required|date_format:H:i',
            'no_pcs' => 'required|string|max:100',
            'stok_kg' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'yarn_material_id' => 'required|exists:yarn_materials,id',
        ]);

        Fabric::create($validated);

        return redirect()->route('yarns.index')
            ->with(['success' => 'Jenis Kain berhasil ditambahkan (Admin).']);
    }
}
