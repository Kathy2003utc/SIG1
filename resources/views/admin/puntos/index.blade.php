@extends('layout.app')

@section('contenido')
<br>
<div class="container">
    <h1 class="mb-4">Puntos de Encuentro</h1>

    <a href="{{ route('admin.puntos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Punto
    </a>

    <a href="{{ route('admin.reportes.puntos') }}" class="btn btn-danger mb-3">
        <i class="fas fa-file-pdf"></i> Generar Reporte
    </a>

    <a href="{{ route('admin.puntos.mapa.publico') }}" class="btn btn-success mb-3">
        <i class="fas fa-map-marker-alt"></i> Ver Mapa
    </a>

    <br><br>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
