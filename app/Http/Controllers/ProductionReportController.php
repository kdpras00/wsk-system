<?php

namespace App\Http\Controllers;

use App\Models\ProductionReport;
use App\Models\ProductionReportDetail;
use App\Models\YarnMaterial; // Correct placement
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Notifications\NewReportSubmitted;
use App\Notifications\ReportStatusChanged;
use Illuminate\Support\Facades\Notification;

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
     * Export reports to Excel (HTML format).
     */
    public function export()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403);
        }

        $reports = ProductionReport::with(['user', 'details'])->latest()->get();
        
        $filename = "laporan_produksi_" . date('Y-m-d_H-i') . ".xls";
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        return view('admin.reports.export_daily', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $yarns = YarnMaterial::where('stock_quantity', '>', 0)->get();
        $order = null;
        if ($request->has('order_id')) {
            $order = \App\Models\ProductionOrder::find($request->order_id);
        }
        
        return view('operator.daily_reports.create', compact('yarns', 'order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'production_order_id' => 'nullable|exists:production_orders,id',
            'machine_name' => 'required|string|max:50',
            'production_date' => 'required|date',
            'notes' => 'nullable|string',
            'shifts' => 'array',
            'shifts.*.shift_name' => 'required|string',
            'shifts.*.counter_start' => 'nullable|numeric',
            'shifts.*.counter_end' => 'nullable|numeric',
            'shifts.*.pcs_count' => 'nullable|numeric',
            'shifts.*.comment' => 'nullable|string',
            'shifts.*.yarn_material_id' => 'nullable|exists:yarn_materials,id',
            'shifts.*.usage_qty' => 'nullable|numeric|min:0',
        ]);

        $report = null;

        DB::transaction(function () use ($validated, &$report) {
            // STOCK CHECK FIRST
            foreach ($validated['shifts'] as $index => $shift) {
                 // ... same logic
                 if (!empty($shift['yarn_material_id']) && !empty($shift['usage_qty']) && $shift['usage_qty'] > 0) {
                     $yarn = YarnMaterial::lockForUpdate()->find($shift['yarn_material_id']);
                     // ...
                     if (!$yarn) {
                          throw \Illuminate\Validation\ValidationException::withMessages([
                             "shifts.$index.yarn_material_id" => ['Bahan benang tidak ditemukan.']
                         ]);
                     }

                     if ($yarn->stock_quantity < $shift['usage_qty']) {
                         throw \Illuminate\Validation\ValidationException::withMessages([
                             "shifts.$index.usage_qty" => ["Stok tidak cukup untuk {$yarn->name}. Tersedia: {$yarn->stock_quantity} {$yarn->unit}, Diminta: {$shift['usage_qty']}."]
                         ]);
                     }
                 }
            }

            // IF ALL CHECKS PASS, CREATE REPORT
            $report = ProductionReport::create([
                'user_id' => Auth::id(),
                'production_order_id' => $validated['production_order_id'] ?? null,
                'machine_name' => $validated['machine_name'],
                'production_date' => $validated['production_date'],
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['shifts'] as $shift) {
                // Skip if no numeric data is provided AND no yarn usage
                if (is_null($shift['counter_start']) && is_null($shift['counter_end']) && is_null($shift['pcs_count']) && empty($shift['usage_qty'])) {
                    continue;
                }

                // Decrement Stock
                if (!empty($shift['yarn_material_id']) && !empty($shift['usage_qty']) && $shift['usage_qty'] > 0) {
                     $yarn = YarnMaterial::find($shift['yarn_material_id']);
                     $yarn->decrement('stock_quantity', $shift['usage_qty']);
                }

                $report->details()->create([
                    'shift_name' => $shift['shift_name'],
                    'counter_start' => $shift['counter_start'] ?? 0,
                    'counter_end' => $shift['counter_end'] ?? 0,
                    'pcs_count' => $shift['pcs_count'] ?? 0,
                    'comment' => $shift['comment'] ?? null,
                    'operator_name' => Auth::user()->name, 
                    'yarn_material_id' => $shift['yarn_material_id'] ?? null,
                    'usage_qty' => $shift['usage_qty'] ?? 0,
                ]);
            }
        });

        // NOTIFY MANAGERS
        $managers = User::where('role', 'manager')->orWhere('role', 'admin')->get();
        Notification::send($managers, new NewReportSubmitted($report));

        return redirect()->route('daily-reports.create')->with('success', 'Laporan Harian berhasil disimpan. Stok bahan otomatis berkurang.');
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
    public function approve(ProductionReport $productionReport)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403);
        }

        $productionReport->update([
            'status' => 'Approved',
            'approved_by' => Auth::id(),
        ]);

        // INCREMENT PRODUCED QUANTITY IN ORDER
        if ($productionReport->production_order_id) {
            $totalPcs = $productionReport->details->sum('pcs_count');
            $order = $productionReport->productionOrder;
            if ($order) {
                $order->increment('produced_quantity', $totalPcs);
            }
        }

        // NOTIFY OPERATOR
        if ($productionReport->user) {
            $productionReport->user->notify(new ReportStatusChanged($productionReport, 'Approved'));
        }

        return back()->with('success', 'Laporan berhasil disetujui.');
    }

    public function reject(Request $request, ProductionReport $productionReport)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403);
        }

        $request->validate(['rejection_note' => 'required|string']);

        DB::transaction(function () use ($productionReport, $request) {
            // Restore Stock
            foreach ($productionReport->details as $detail) {
                if ($detail->yarn_material_id && $detail->usage_qty > 0) {
                    $yarn = YarnMaterial::find($detail->yarn_material_id);
                    if ($yarn) {
                        $yarn->increment('stock_quantity', $detail->usage_qty);
                    }
                }
            }

            $productionReport->update([
                'status' => 'Rejected',
                'approved_by' => Auth::id(),
                'rejection_note' => $request->rejection_note,
            ]);
        });

        // NOTIFY OPERATOR
        if ($productionReport->user) {
            $productionReport->user->notify(new ReportStatusChanged($productionReport, 'Rejected'));
        }

        return back()->with('success', 'Laporan ditolak. Stok bahan telah dikembalikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionReport $productionReport)
    {
        // Only allow delete if Pending or Rejected? 
        // For now, let's keep it simple or implement restricted delete later.
        $productionReport->delete();
        return back()->with('success', 'Laporan dihapus.');
    }
}
