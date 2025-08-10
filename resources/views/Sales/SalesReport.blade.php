<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de ventas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Reporte de ventas</h2>
    <p>Fecha de inicio: {{ $start_date }}</p>
    <p>Fecha de fin: {{ $end_date }}</p>
    <p>Fecha de reporte: {{ $date }}</p>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Número de venta</th>
            <th>Nombre del cliente</th>
            <th>Total</th>
        </tr>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->date }}</td>
                <td>{{ $sale->number }}</td>
                <td>{{ $sale->person_fname ?? 'N/A' }} {{ $sale->person_lastname ?? 'N/A' }}</td>
                <td>Gs. {{ $sale->total }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-right">Total:</td>
            <td>Gs. {{ $sales->sum('total') }}</td>
        </tr>
    </table>
</body>
</html>
