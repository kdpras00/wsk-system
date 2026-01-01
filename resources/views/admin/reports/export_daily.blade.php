<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="3" rowspan="2" style="text-align: left; vertical-align: middle;">
                    <img src="{{ asset('assets/img/logo-wsk.png') }}" alt="WSK Logo" height="60">
                </th>
                <th colspan="12" style="font-size: 16px; font-weight: bold; text-align: center; vertical-align: middle;">REKAPITULASI LAPORAN PRODUKSI HARIAN</th>
            </tr>
            <tr>
                <th colspan="12" style="text-align: center;">Generated: {{ date('d M Y H:i') }}</th>
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
            <tr><td colspan="15"></td></tr>
            <tr>
                <td colspan="15"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td colspan="3" style="text-align: center;">Dibuat Oleh,</td>
                <td colspan="4"></td>
                <td colspan="3" style="text-align: center;">Disetujui Oleh,</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="15" style="height: 60px;"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td colspan="3" style="text-align: center;">( ......................... )</td>
                <td colspan="4"></td>
                <td colspan="3" style="text-align: center;">( Manager )</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
