<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Puntos de Encuentro</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
        .center { text-align: center; }
        .section-title { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

<h2 class="center">Reporte de Puntos de Encuentro</h2>

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
            <td>{{ $punto->capacidad }}</td>
            <td>{{ $punto->responsable }}</td>
            <td>{{ $punto->latitud }}, {{ $punto->longitud }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="section-title">Mapa Estático de Puntos:</div>
<img src="{{ $mapa_url }}" alt="Mapa de puntos de encuentro" style="width: 100%; border:1px solid #aaa;">

<div class="section-title">QR para ver mapa en línea:</div>
<img src="data:image/png;base64,{{ $qrCodeB64 }}" width="150" height="150">

</body>
</html>
