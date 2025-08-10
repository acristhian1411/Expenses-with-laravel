<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de compras</title>
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
    <h2>Reporte de compras</h2>
    <p>Fecha de inicio: {{ $start_date }}</p>
    <p>Fecha de fin: {{ $end_date }}</p>
    <p>Fecha de reporte: {{ $date }}</p>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Número de compra</th>
            <th>Nombre del proveedor</th>
            <th>Total</th>
        </tr>
        @foreach ($purchases as $purchase)
            <tr>
                <td>{{ $purchase->date }}</td>
                <td>{{ $purchase->number }}</td>
                <td>{{ $purchase->person_fname ?? 'N/A' }} {{ $purchase->person_lastname ?? 'N/A' }}</td>
                <td>Gs. {{ $purchase->total }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-right">Total:</td>
            <td>Gs. {{ $purchases->sum('total') }}</td>
        </tr>
    </table>
</body>
</html>
