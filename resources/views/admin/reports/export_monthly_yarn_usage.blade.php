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
    <h2>Laporan Bulanan Pemakaian Benang & Hasil Kain</h2>
    <p>Periode: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>

    <table>
        <thead>
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
        </tbody>
    </table>
</body>
</html>
