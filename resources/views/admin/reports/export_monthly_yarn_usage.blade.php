<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Pemakaian Benang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="2" rowspan="2" style="text-align: left; vertical-align: middle;">
                    <img src="{{ asset('assets/img/logo-wsk.png') }}" alt="WSK Logo" height="60">
                </th>
                <th colspan="4" style="font-size: 16px; font-weight: bold; text-align: center; vertical-align: middle;">Laporan Bulanan Pemakaian Benang & Hasil Kain</th>
            </tr>
            <tr>
                 <th colspan="4" style="text-align: center;">Periode: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</th>
            </tr>
            <tr>
                <th>Mesin</th>
                <th>Pattern</th>
                <th>Benang</th>
                <th>Total Pemakaian Benang (KG)</th>
                <th>Total Hasil Kain (Meter)</th>
                <th>Total Hasil Kain (KG)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row->machine_name }}</td>
                    <td>{{ $row->pattern ?? '-' }}</td>
                    <td>{{ $row->yarn_name }}</td>
                    <td style="text-align: right;">{{ number_format($row->total_usage_qty, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($row->total_meter_count, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($row->total_kg_count, 2) }}</td>
                </tr>
            @endforeach
            <tr><td colspan="6"></td></tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="1"></td>
                <td colspan="2" style="text-align: center;">Dibuat Oleh,</td>
                <td colspan="1"></td>
                <td colspan="2" style="text-align: center;">Disetujui Oleh,</td>
            </tr>
            <tr>
                <td colspan="6" style="height: 60px;"></td>
            </tr>
            <tr>
                <td colspan="1"></td>
                <td colspan="2" style="text-align: center;">( ......................... )</td>
                <td colspan="1"></td>
                <td colspan="2" style="text-align: center;">( Manager )</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
