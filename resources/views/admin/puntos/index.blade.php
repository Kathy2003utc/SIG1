@extends('layout.app')

@section('contenido')
<br>
<div class="container">
    <h1 class="mb-4">Puntos de Encuentro</h1>

    <a href="{{ route('admin.puntos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Punto
    </a>

    <a href="{{ route('admin.puntos.reporte') }}" class="btn btn-danger mb-3">
        <i class="fas fa-file-pdf"></i> Generar Reporte
    </a>

    <br><br>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="mapa" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>

    <br><br>
    <table class="table table-bordered" id="zonas-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Responsable</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($puntos as $punto)
                <tr>
                    <td>{{ $punto->nombre }}</td>
                    <td>{{ $punto->capacidad }}</td>
                    <td>{{ $punto->responsable }}</td>
                    <td>{{ $punto->latitud }}</td>
                    <td>{{ $punto->longitud }}</td>
                    <td>
                        <a href="{{ route('admin.puntos.edit', $punto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.puntos.destroy', $punto->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Eliminar punto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    let mapa;
    const centroInicial = { lat: -0.9374805, lng: -78.6161327 };
    const puntos = @json($puntos);

    function initMap() {
        mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: centroInicial,
            zoom: 12,
        });

        puntos.forEach(punto => {
            if (punto.latitud && punto.longitud) {
                const pos = {
                    lat: parseFloat(punto.latitud),
                    lng: parseFloat(punto.longitud)
                };

                const iconUrl = punto.logo_url ? `/${punto.logo_url}` : null;

                const marker = new google.maps.Marker({
                    position: pos,
                    map: mapa,
                    icon: iconUrl ? {
                        url: iconUrl,
                        scaledSize: new google.maps.Size(50, 50)
                    } : null,
                    title: punto.nombre
                });

                const infowindow = new google.maps.InfoWindow({
                    content: `
                        <div style="
                            font-family: Arial, sans-serif;
                            color: #004d00;
                            background-color: #d9f2d9;
                            padding: 10px 15px;
                            border-radius: 8px;
                            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                            min-width: 180px;
                            line-height: 1.4;
                        ">
                            <h3 style="margin-top: 0; margin-bottom: 8px; font-size: 18px; color: #2d572c;">${punto.nombre}</h3>
                            <p style="margin: 0; font-weight: bold;">Capacidad: <span style="color: #27632a;">${punto.capacidad}</span></p>
                            <p style="margin: 0;">Responsable: <span style="color: #27632a;">${punto.responsable}</span></p>
                        </div>`
                });

                marker.addListener('mouseover', () => infowindow.open(mapa, marker));
                marker.addListener('mouseout', () => infowindow.close());
            }
        });
    }

    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdYzugNC_QlesLopg6J4884TRsBzvusjg&callback=initMap">
</script>

<!-- DataTables JS -->
<script>
    $(document).ready(function() {
        $('#zonas-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

@endsection
