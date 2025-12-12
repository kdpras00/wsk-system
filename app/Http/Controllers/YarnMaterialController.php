<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YarnMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $yarns = \App\Models\YarnMaterial::latest()->paginate(10, ['*'], 'yarns_page');
        $fabrics = \App\Models\Fabric::latest()->paginate(10, ['*'], 'fabrics_page');
        return view('yarns.index', compact('yarns', 'fabrics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'operator') {
            abort(403);
        }
        return view('yarns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        if (auth()->user()->role === 'operator') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
            'stock_quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|in:kg,rolls,pcs', // Example units
            'batch_number' => 'nullable|string|max:100',
        ]);

        if (empty($validated['color'])) {
            $validated['color'] = '-';
        }

        \App\Models\YarnMaterial::create($validated);

        return redirect()->route('yarns.index')->with('success', 'Yarn material added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->role === 'operator') {
            abort(403);
        }
        $yarn = \App\Models\YarnMaterial::findOrFail($id);
        return view('yarns.edit', compact('yarn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, string $id)
    {
        if (auth()->user()->role === 'operator') {
            abort(403);
        }

         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
            'stock_quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|in:kg,rolls,pcs',
            'batch_number' => 'nullable|string|max:100',
        ]);

        if (empty($validated['color'])) {
            $validated['color'] = '-';
        }

        $yarn = \App\Models\YarnMaterial::findOrFail($id);
        $yarn->update($validated);

        return redirect()->route('yarns.index')->with('success', 'Yarn material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role === 'operator') {
            abort(403);
        }

        $yarn = \App\Models\YarnMaterial::findOrFail($id);
        $yarn->delete();

        return redirect()->route('yarns.index')->with('success', 'Yarn material deleted successfully.');
    }
}
