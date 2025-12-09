<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\ProductionOrder::with('manager', 'items')->latest()->paginate(10);
        return view('production.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yarns = \App\Models\YarnMaterial::all();
        return view('production.create', compact('yarns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'order_number' => 'required|string|unique:production_orders',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'items' => 'required|array|min:1',
            'items.*.yarn_material_id' => 'required|exists:yarn_materials,id',
            'items.*.planned_quantity' => 'required|numeric|min:0.1',
        ]);

        $order = \App\Models\ProductionOrder::create([
            'order_number' => $request->order_number,
            'manager_id' => auth()->id(),
            'status' => 'Planned',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        foreach ($request->items as $item) {
            $order->items()->create([
                'yarn_material_id' => $item['yarn_material_id'],
                'planned_quantity' => $item['planned_quantity'],
            ]);
        }

        return redirect()->route('production.index')->with('success', 'Production Order created successfully.');
    }

    public function updateStatus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Planned,In Progress,Completed,Cancelled'
        ]);

        $order = \App\Models\ProductionOrder::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated to ' . $request->status);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
