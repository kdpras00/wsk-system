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
        if (auth()->user()->role === 'operator') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'order_number' => 'required|string|unique:production_orders',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'target_quantity' => 'required|numeric|min:1', // Added
            'items' => 'required|array|min:1',
            'items.*.yarn_material_id' => 'required|exists:yarn_materials,id',
            'items.*.planned_quantity' => 'required|numeric|min:0.1',
        ]);

        $order = \App\Models\ProductionOrder::create([
            'order_number' => $request->order_number,
            'manager_id' => auth()->id(),
            'target_quantity' => $request->target_quantity, // Added
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

        // Notify All Generic Operators
        // In a real app, you might scope this, but for now all operators get notified.
        $operators = \App\Models\User::where('role', 'operator')->get();
        \Illuminate\Support\Facades\Notification::send($operators, new \App\Notifications\NewOrderAvailable($order));

        return redirect()->route('production.index')->with('success', 'Production Order created successfully.');
    }

    public function updateStatus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Planned,In Progress,Pending Check,Completed,Cancelled'
        ]);

        // Authorization Check
        if ($request->status === 'Completed' && auth()->user()->role === 'operator') {
            return back()->with('error', 'Only Managers can verify and complete orders.');
        }

        if ($request->status === 'Cancelled' && auth()->user()->role === 'operator') {
             return back()->with('error', 'Only Managers can cancel orders.');
        }

        $order = \App\Models\ProductionOrder::findOrFail($id);
        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Notification Logic
        if ($request->status === 'Pending Check' && $oldStatus !== 'Pending Check') {
            // Notify Manager
            $manager = $order->manager; 
            // Also notify other managers/admins just in case? Or just the owner.
            if ($manager) {
                $manager->notify(new \App\Notifications\OrderPendingCheck($order));
            }
        } elseif ($request->status === 'Completed' && $oldStatus !== 'Completed') {
            // Optional: Notify Operator that job is done?
            // Since we don't know exactly which operator "owned" it, maybe skip or implement generic.
        }

        return back()->with('success', 'Order status updated to ' . $request->status);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = \App\Models\ProductionOrder::with(['items.yarnMaterial', 'manager', 'productionReports.user'])->findOrFail($id);
        return view('production.show', compact('order'));
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
