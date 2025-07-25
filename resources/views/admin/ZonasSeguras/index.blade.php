@extends('layout.app')

@section('contenido')

<div class="container mt-5">
    <h2 class="mb-4">Zonas Seguras Registradas</h2>

    <a href="{{ route('admin.ZonasSeguras.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Nueva Zona Segura
    </a>
   
    <a href="{{ route('admin.reportes.zonas_seguras') }}" class="btn btn-primary mb-3">

        <i class="fas fa-file-pdf"></i> Reporte PDF
    </a>

    <a href="{{ route('admin.ZonasSeguras.mapa') }}" class="btn btn-success mb-3">
        <i class="fas fa-map-marker-alt"></i> Ver Mapa
    </a>


    {{-- Mensajes de éxito con SweetAlert --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981'
            });
        </script>
    @endif

    <div class="table-responsive">
        <table id="zonas-table" class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Radio (m)</th>
                    <th>Coordenadas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($zonasSeguras as $zona)
                    <tr>
                        <td>{{ $zona->id }}</td>
                        <td>{{ $zona->nombre }}</td>
                        <td>{{ $zona->tipo_seguridad }}</td>
                        <td>{{ $zona->radio }}</td>
                        <td>{{ $zona->latitud }}<br>{{ $zona->longitud }}</td>
                        <td>
                            {{-- Botón Editar --}}
                            <a href="{{ route('admin.ZonasSeguras.edit', $zona->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            {{-- Formulario Eliminar con confirmación SweetAlert --}}
                            <form id="delete-form-{{ $zona->id }}" action="{{ route('admin.ZonasSeguras.destroy', $zona->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminacion({{ $zona->id }}, '{{ $zona->nombre }}')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay zonas seguras registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#zonas-table').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print'
        ]
    });
});
</script>

<script>
    function confirmarEliminacion(id, nombre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar la zona segura "${nombre}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>

@endsection
