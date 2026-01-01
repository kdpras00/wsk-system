<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="2" rowspan="2" style="text-align: left; vertical-align: middle;">
                    <img src="{{ asset('assets/img/logo-wsk.png') }}" alt="WSK Logo" height="60">
                </th>
                <th colspan="6" style="font-size: 16px; font-weight: bold; text-align: center; vertical-align: middle;">REKAPITULASI LAPORAN HARIAN (ADMIN SUMMARY)</th>
            </tr>
            <tr>
                <th colspan="6" style="text-align: center;">Generated: {{ date('d M Y H:i') }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Mesin</th>
                <th>Operator</th>
                <th>Global Shift</th>
                <th>Total Output (PCS)</th>
                <th>Status</th>
                <th>Mengetahui (Manager)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $report->production_date->format('d/m/Y') }}</td>
                <td>{{ $report->machine_name }}</td>
                <td>{{ $report->user->name ?? 'Unknown' }}</td>
                <td>{{ $report->details->first()->shift_name ?? '-' }}</td>
                <td>{{ $report->details->sum('pcs_count') }}</td>
                <td>{{ $report->status }}</td>
                <td>{{ $report->approvedBy->name ?? '-' }}</td>
            </tr>
            @endforeach
            <tr><td colspan="8"></td></tr>
            <tr>
                <td colspan="8"></td>
            </tr>
            <tr>
                <td colspan="1"></td>
                <td colspan="2" style="text-align: center;">Dibuat Oleh,</td>
                <td colspan="2"></td>
                <td colspan="2" style="text-align: center;">Disetujui Oleh,</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="8" style="height: 60px;"></td>
            </tr>
            <tr>
                <td colspan="1"></td>
                <td colspan="2" style="text-align: center;">( ......................... )</td>
                <td colspan="2"></td>
                <td colspan="2" style="text-align: center;">( Manager )</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
