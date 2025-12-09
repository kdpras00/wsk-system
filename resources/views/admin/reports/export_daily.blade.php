<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="7" style="font-size: 16px; font-weight: bold; text-align: center;">REKAPITULASI LAPORAN PRODUKSI HARIAN</th>
            </tr>
            <tr>
                <th colspan="7" style="text-align: center;">Generated: {{ date('d M Y H:i') }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Operator</th>
                <th>Mesin</th>
                <th>Shift</th>
                <th>Output (PCS)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                @foreach($report->details as $index => $detail)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->production_date->format('d/m/Y') }}</td>
                    <td>{{ $report->user->name ?? $detail->operator_name }}</td>
                    <td>{{ $report->machine_name }}</td>
                    <td>{{ $detail->shift_name }}</td>
                    <td>{{ $detail->pcs_count }}</td>
                    <td>{{ $detail->comment }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
