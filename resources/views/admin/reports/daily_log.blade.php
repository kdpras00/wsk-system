@extends('layouts.app')

@section('header', 'Rekapitulasi Laporan Harian')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
             <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Rekapitulasi Laporan Harian</h2>
             <p class="text-slate-500 mt-1">Laporan produksi harian dari semua operator.</p>
        </div>
        <a href="{{ route('daily-reports.export_summary') }}" target="_blank" id="export-btn" class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-600 rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span id="export-text">Export Excel (Rekap Admin)</span>
        </a>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6 border-b border-slate-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button onclick="switchTab('summary')" id="summary-tab" class="inline-block p-4 rounded-t-lg border-b-2 border-indigo-600 text-indigo-600 active hover:text-indigo-600 hover:border-indigo-600 transition-all font-bold" type="button" role="tab" aria-controls="summary" aria-selected="true">
                    Laporan Admin (Rekap)
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button onclick="switchTab('details')" id="details-tab" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-slate-600 hover:border-slate-300 text-slate-500 transition-all font-bold" type="button" role="tab" aria-controls="details" aria-selected="false">
                    Laporan Operator (Log Sheet Unit)
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">
        
        <!-- Tab 1: Summary (Admin View) -->
        <div id="tab-summary" class="block">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Tanggal</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">No. Mesin</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Operator</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Total Output (PCS)</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs text-center">Status</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                        @forelse($reports as $report)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $report->production_date->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $report->machine_name }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $report->user->name ?? 'Unknown' }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $report->details->sum('pcs_count') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($report->status == 'Approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                        Approved
                                    </span>
                                @elseif($report->status == 'Rejected')
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                        Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('daily-reports.show', $report->id) }}" class="p-1 text-slate-400 hover:text-blue-600 transition-colors" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    @if($report->status == 'Pending')
                                        <form id="approve-form-{{ $report->id }}" action="{{ route('daily-reports.approve', $report->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" onclick="confirmFormSubmission(event, 'approve-form-{{ $report->id }}', 'Approve Laporan?', 'Stok benang akan dikurangi sesuai pemakaian.', 'Ya, Approve!', 'success')" class="p-1 text-slate-400 hover:text-green-600 transition-colors" title="Approve">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>
                                        <button type="button" onclick="rejectReport({{ $report->id }})" class="p-1 text-slate-400 hover:text-red-500 transition-colors" title="Reject">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <form id="reject-form-{{ $report->id }}" action="{{ route('daily-reports.reject', $report->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="rejection_note" id="rejection_note_{{ $report->id }}">
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada laporan harian yang masuk.
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 2: Details (Operator View) -->
        <div id="tab-details" class="hidden">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                            <tr>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Tanggal</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Operator</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Mesin</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Shift</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Jenis Benang</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Pattern</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Jam</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Meter</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">No. PCS</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Grade</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Stok (Kg)</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Posisi Putus</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Masalah</th>
                                <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Keterangan</th>
                            </tr>
                        </thead>
                         <tbody class="divide-y divide-slate-50">
                            @foreach($reports as $report)
                                @foreach($report->details as $detail)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3 px-6 text-slate-900 font-medium">{{ $report->production_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ $report->user->name ?? $detail->operator_name }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ $report->machine_name }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ $detail->shift_name }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ $detail->yarnMaterial->name ?? '-' }}</td>
                                    <td class="py-3 px-6 text-indigo-600 font-bold">{{ $detail->pattern }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ \Carbon\Carbon::parse($detail->jam)->format('H:i') }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ $detail->meter_count }}</td>
                                    <td class="py-3 px-6 text-slate-600">{{ $detail->no_pcs }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="font-bold {{ $detail->grade == 'A' ? 'text-green-600' : ($detail->grade == 'BS' ? 'text-red-500' : 'text-yellow-600') }}">
                                            {{ $detail->grade }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-slate-600 font-bold">{{ $detail->usage_qty }}</td>
                                    <td class="py-3 px-6 text-xs text-slate-400">{{ $detail->posisi_benang_putus }}</td>
                                    <td class="py-3 px-6 text-xs text-slate-400">{{ $detail->kode_masalah }}</td>
                                    <td class="py-3 px-6 text-xs text-slate-400 truncate max-w-[200px]">{{ $detail->comment ?? '-' }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                         </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const exportSummaryUrl = "{{ route('daily-reports.export_summary') }}";
    const exportDetailsUrl = "{{ route('daily-reports.export_details') }}";

    function rejectReport(id) {
        Swal.fire({
            title: 'Tolak Laporan?',
            text: "Berikan alasan penolakan (Stok akan dikembalikan):",
            input: 'textarea',
            inputPlaceholder: 'Tulis alasan disini...',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Tolak & Refund Stok',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan wajib diisi!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('rejection_note_' + id).value = result.value;
                document.getElementById('reject-form-' + id).submit();
            }
        })
    }

    function switchTab(tabName) {
        const summaryTab = document.getElementById('tab-summary');
        const detailsTab = document.getElementById('tab-details');
        const summaryBtn = document.getElementById('summary-tab');
        const detailsBtn = document.getElementById('details-tab');
        
        // Single Export Button
        const exportBtn = document.getElementById('export-btn');
        const exportText = document.getElementById('export-text');

        if (tabName === 'summary') {
            summaryTab.classList.remove('hidden');
            detailsTab.classList.add('hidden');
            
            // Active Style Summary
            summaryBtn.classList.add('border-indigo-600', 'text-indigo-600');
            summaryBtn.classList.remove('border-transparent', 'text-slate-500');
            
            // Inactive Style Details
            detailsBtn.classList.remove('border-indigo-600', 'text-indigo-600');
            detailsBtn.classList.add('border-transparent', 'text-slate-500');

            // Update Export Button to SUMMARY
            exportBtn.href = exportSummaryUrl;
            exportText.innerText = "Export Excel (Rekap Admin)";
            
        } else {
            summaryTab.classList.add('hidden');
            detailsTab.classList.remove('hidden');
            
             // Inactive Style Summary
            summaryBtn.classList.remove('border-indigo-600', 'text-indigo-600');
            summaryBtn.classList.add('border-transparent', 'text-slate-500');
            
            // Active Style Details
            detailsBtn.classList.add('border-indigo-600', 'text-indigo-600');
            detailsBtn.classList.remove('border-transparent', 'text-slate-500');

            // Update Export Button to DETAILS
            exportBtn.href = exportDetailsUrl;
            exportText.innerText = "Export Excel (Detail Operator)";
        }
    }
</script>
@endsection
