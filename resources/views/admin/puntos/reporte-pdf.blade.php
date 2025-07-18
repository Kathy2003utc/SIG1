<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Puntos de Encuentro</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f0f0f0; }
        .center { text-align: center; }
        .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Reporte de Puntos de Encuentro</h2>

<div class="section-title">Lista de Puntos:</div>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Capacidad</th>
            <th>Responsable</th>
            <th>Coordenadas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($puntos as $punto)
        <tr>
            <td>{{ $punto->nombre }}</td>
            <td class="center">{{ $punto->capacidad }}</td>
            <td>{{ $punto->responsable }}</td>
            <td>{{ $punto->latitud }}, {{ $punto->longitud }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
