@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Puntos de Encuentro</h1>

    <a href="{{ route('admin.puntos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Punto
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="mapa" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>

    <table class="table table-bordered">
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
            @forelse ($puntos as $punto)
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
            @empty
            <tr>
                <td colspan="8" class="text-center">No hay riesgos registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function initMap() {
        const mapa = new google.maps.Map(document.getElementById('mapa'), {
            zoom: 12,
            center: { lat: -0.9374805, lng: -78.6161327 }
        });

        const iconoPersonalizado = {
            url: '/images/marker-icon.png', // Cambia la ruta si tienes otro icono
            scaledSize: new google.maps.Size(40, 40)
        };

        @foreach($puntos as $punto)
            new google.maps.Marker({
                position: { lat: {{ $punto->latitud }}, lng: {{ $punto->longitud }} },
                map: mapa,
                title: "{{ $punto->nombre }}",
                icon: iconoPersonalizado
            });
        @endforeach
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>


@endsection
