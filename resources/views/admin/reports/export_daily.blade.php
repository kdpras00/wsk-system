<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="15" style="font-size: 16px; font-weight: bold; text-align: center;">REKAPITULASI LAPORAN PRODUKSI HARIAN</th>
            </tr>
            <tr>
                <th colspan="15" style="text-align: center;">Generated: {{ date('d M Y H:i') }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Operator</th>
                <th>Mesin</th>
                <th>Shift</th>
                <th>Jenis Benang</th>
                <th>Pattern</th>
                <th>Jam</th>
                <th>Meter</th>
                <th>No. PCS</th>
                <th>Grade</th>
                <th>Stok (Kg)</th>
                <th>Posisi Putus</th>
                <th>Masalah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                @foreach($report->details as $index => $detail)
                <tr>
                    <td>{{ $loop->parent->iteration }}</td>
                    <td>{{ $report->production_date->format('d/m/Y') }}</td>
                    <td>{{ $report->user->name ?? $detail->operator_name }}</td>
                    <td>{{ $report->machine_name }}</td>
                    <td>{{ $detail->shift_name }}</td>
                    <td>{{ $detail->yarnMaterial->name ?? '-' }}</td>
                    <td>{{ $detail->pattern ?? '-' }}</td>
                    <td>{{ $detail->jam ? \Carbon\Carbon::parse($detail->jam)->format('H:i') : '-' }}</td>
                    <td>{{ $detail->meter_count }}</td>
                    <td>{{ $detail->no_pcs }}</td>
                    <td>{{ $detail->grade }}</td>
                    <td>{{ $detail->usage_qty }}</td>
                    <td>{{ $detail->posisi_benang_putus }}</td>
                    <td>{{ $detail->kode_masalah }}</td>
                    <td>{{ $detail->comment }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
