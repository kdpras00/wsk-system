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
        $reports = ProductionReport::where('user_id', Auth::id())->with('details')->latest()->paginate(10);
        return view('operator.daily_reports.index', compact('reports'));
    }

    /**
     * Export reports to Excel (HTML format).
     */
    /**
     * Export reports DETAILED (Operator View) to Excel.
     */
    public function exportDetails()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403);
        }

        $reports = ProductionReport::with(['user', 'details'])->latest()->get();
        
        $filename = "laporan_detail_operator_" . date('Y-m-d_H-i') . ".xls";
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        return view('admin.reports.export_daily', compact('reports'));
    }

    /**
     * Export reports SUMMARY (Admin View) to Excel.
     */
    public function exportSummary()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403);
        }

        $reports = ProductionReport::with(['user', 'details', 'approvedBy'])->latest()->get();
        
        $filename = "rekap_admin_" . date('Y-m-d_H-i') . ".xls";
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        return view('admin.reports.export_summary', compact('reports'));
    }


    /**
     * Show Monthly Yarn Usage & Fabric Output Report.
     */
    public function monthlyYarnUsage(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403);
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Query production details filtered by month/year of the PARENT report
        $data = DB::table('production_report_details')
            ->join('production_reports', 'production_report_details.production_report_id', '=', 'production_reports.id')
            ->leftJoin('yarn_materials', 'production_report_details.yarn_material_id', '=', 'yarn_materials.id')
            ->select(
                'production_reports.machine_name',
                'production_report_details.pattern',
                'yarn_materials.name as yarn_name',
                DB::raw('SUM(production_report_details.usage_qty) as total_usage_qty'),
                DB::raw('SUM(production_report_details.meter_count) as total_meter_count'),
                DB::raw('SUM(production_report_details.kg_count) as total_kg_count')
            )
            ->whereMonth('production_reports.production_date', $month)
            ->whereYear('production_reports.production_date', $year)
            ->whereNotNull('production_report_details.yarn_material_id') // Ensure we only count rows with yarn usage
            ->groupBy('production_reports.machine_name', 'production_report_details.pattern', 'yarn_materials.name')
            ->orderBy('production_reports.machine_name')
            ->orderBy('production_report_details.pattern')
            ->get();

        // Check if Export Requested
        if ($request->has('export') && $request->input('export') == 'true') {
            $filename = "rekap_bahan_kain_{$year}-{$month}_" . date('Y-m-d_H-i') . ".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            return view('admin.reports.export_monthly_yarn_usage', compact('data', 'month', 'year'));
        }

        return view('admin.reports.monthly_yarn_usage', compact('data', 'month', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yarns = YarnMaterial::all();
        // Fetch distinct patterns and their linked yarn for auto-selection logic
        // We group by pattern to assume 1 pattern = 1 yarn recipe. If multiple, we take the latest.
        $fabricMapping = \App\Models\Fabric::select('pattern', 'yarn_material_id')
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->unique('pattern')
                            ->keyBy('pattern');
        
        $patterns = $fabricMapping->keys();
        
        return view('operator.daily_reports.create', compact('yarns', 'patterns', 'fabricMapping'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'production_order_id' => 'nullable|exists:production_orders,id',
            'machine_name' => 'required|string|max:50',
            'production_date' => 'required|date',
            'shift_name' => 'required|string', // Global Shift for this report
            'notes' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.yarn_material_id' => 'nullable|exists:yarn_materials,id', // Per-row Yarn
            'details.*.pattern' => 'nullable|string|max:255', // Per-row Pattern (Text)
            'details.*.jam' => 'nullable|date_format:H:i',
            'details.*.meter_count' => 'nullable|numeric|min:0',
            'details.*.no_pcs' => 'nullable|string|max:50',
            'details.*.grade' => 'nullable|string|max:10',
            'details.*.usage_qty' => 'nullable|numeric|min:0',
            'details.*.posisi_benang_putus' => 'nullable|string|max:255',
            'details.*.kode_masalah' => 'nullable|string|max:50',
            'details.*.comment' => 'nullable|string',
        ]);

        $report = null;

        DB::transaction(function () use ($validated, &$report) {
            // 1. CALCULATE TOTAL USAGE PER YARN
            $usagePerYarn = [];
            foreach ($validated['details'] as $detail) {
                if (!empty($detail['yarn_material_id']) && !empty($detail['usage_qty'])) {
                    $yarnId = $detail['yarn_material_id'];
                    if (!isset($usagePerYarn[$yarnId])) {
                        $usagePerYarn[$yarnId] = 0;
                    }
                    $usagePerYarn[$yarnId] += $detail['usage_qty'];
                }
            }

            // 2. CHECK STOCK & LOCK RECORDS
            foreach ($usagePerYarn as $yarnId => $totalRequested) {
                $yarn = YarnMaterial::lockForUpdate()->find($yarnId);
                if ($yarn->stock_quantity < $totalRequested) {
                     throw \Illuminate\Validation\ValidationException::withMessages([
                         "details" => ["Stok tidak cukup untuk {$yarn->name}. Tersedia: {$yarn->stock_quantity} {$yarn->unit}, Total Diminta: {$totalRequested}."]
                     ]);
                }
            }

            // 3. CREATE REPORT HEADER
            $report = ProductionReport::create([
                'user_id' => Auth::id(),
                'production_order_id' => $validated['production_order_id'] ?? null,
                'machine_name' => $validated['machine_name'],
                'production_date' => $validated['production_date'],
                'notes' => $validated['notes'],
            ]);

            // 4. UPDATE STOCK (DECREMENT)
            foreach ($usagePerYarn as $yarnId => $totalRequested) {
                 $yarn = YarnMaterial::find($yarnId);
                 $yarn->decrement('stock_quantity', $totalRequested);
            }

            // 5. CREATE REPORT DETAILS
            foreach ($validated['details'] as $detail) {
                // Skip completely empty rows if any
                if (empty($detail['jam']) && empty($detail['meter_count']) && empty($detail['usage_qty'])) {
                    continue;
                }

                $report->details()->create([
                    'shift_name' => $validated['shift_name'], // Uses global shift
                    'jam' => $detail['jam'] ?? null,
                    'meter_count' => $detail['meter_count'] ?? 0,
                    'no_pcs' => $detail['no_pcs'] ?? null,
                    'grade' => $detail['grade'] ?? null,
                    'pattern' => $detail['pattern'] ?? null, // Save Pattern Name
                    'usage_qty' => $detail['usage_qty'] ?? 0,
                    'posisi_benang_putus' => $detail['posisi_benang_putus'] ?? null,
                    'kode_masalah' => $detail['kode_masalah'] ?? null,
                    'comment' => $detail['comment'] ?? null,
                    'operator_name' => Auth::user()->name, 
                    'yarn_material_id' => $detail['yarn_material_id'] ?? null,
                ]);
            }
        });

        // NOTIFY MANAGERS
        $managers = User::where('role', 'manager')->orWhere('role', 'admin')->get();
        Notification::send($managers, new NewReportSubmitted($report));

        return redirect()->route('daily-reports.create')->with('success', 'Laporan Log Sheet berhasil disimpan.');
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

        // SMART NOTIFICATION: Mark "New Report" notification as read for this admin
        Auth::user()->unreadNotifications
            ->where('type', \App\Notifications\NewReportSubmitted::class)
            ->filter(function ($notification) use ($productionReport) {
                return isset($notification->data['report_id']) && $notification->data['report_id'] == $productionReport->id;
            })
            ->markAsRead();

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

        // SMART NOTIFICATION: Mark "New Report" notification as read for this admin
        Auth::user()->unreadNotifications
            ->where('type', \App\Notifications\NewReportSubmitted::class)
            ->filter(function ($notification) use ($productionReport) {
                return isset($notification->data['report_id']) && $notification->data['report_id'] == $productionReport->id;
            })
            ->markAsRead();

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
