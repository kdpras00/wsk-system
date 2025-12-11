<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="6" style="font-size: 16px; font-weight: bold; text-align: center;">REKAPITULASI LAPORAN HARIAN (ADMIN SUMMARY)</th>
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
                <td>{{ $report->approvedDetail->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
