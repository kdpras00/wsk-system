<?php

namespace App\Http\Controllers;

use App\Models\ProductionReport;
use App\Models\ProductionReportDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admin View: Table Recap
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager') {
            $reports = ProductionReport::with(['user', 'details'])->latest()->get();
            return view('admin.reports.daily_log', compact('reports'));
        }

        // Operator View: My History
        $reports = ProductionReport::where('user_id', Auth::id())->with('details')->latest()->get();
        return view('operator.daily_reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.daily_reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'machine_name' => 'required|string|max:50',
            'production_date' => 'required|date',
            'notes' => 'nullable|string',
            'shifts' => 'array',
            'shifts.*.shift_name' => 'required|string',
            'shifts.*.counter_start' => 'nullable|numeric',
            'shifts.*.counter_end' => 'nullable|numeric',
            'shifts.*.pcs_count' => 'nullable|numeric',
            'shifts.*.comment' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $report = ProductionReport::create([
                'user_id' => Auth::id(),
                'machine_name' => $validated['machine_name'],
                'production_date' => $validated['production_date'],
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['shifts'] as $shift) {
                // Skip if no numeric data is provided
                if (is_null($shift['counter_start']) && is_null($shift['counter_end']) && is_null($shift['pcs_count'])) {
                    continue;
                }

                $report->details()->create([
                    'shift_name' => $shift['shift_name'],
                    'counter_start' => $shift['counter_start'] ?? 0,
                    'counter_end' => $shift['counter_end'] ?? 0,
                    'pcs_count' => $shift['pcs_count'] ?? 0,
                    'comment' => $shift['comment'] ?? null,
                    'operator_name' => Auth::user()->name, 
                ]);
            }
        });

        return redirect()->route('daily-reports.create')->with('success', 'Laporan Harian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionReport $productionReport)
    {
        $productionReport->load('details');
        return view('admin.reports.show_daily', compact('productionReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionReport $productionReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionReport $productionReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionReport $productionReport)
    {
        //
    }
}
