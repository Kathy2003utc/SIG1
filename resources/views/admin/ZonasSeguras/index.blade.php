@extends('layout.app')

@section('contenido')

<div class="container mt-5">
    <h2 class="mb-4">Zonas Seguras Registradas</h2>

    {{-- Botón Agregar --}}
    <a href="{{ route('ZonasSeguras.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Nueva Zona Segura
    </a>

    {{-- Botón Vista previa del reporte --}}
    <a href="#" class="btn btn-primary mb-3">
        <i class="fas fa-map"></i> Vista previa del reporte
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
                        <td>{{ $zona->latitud }}, {{ $zona->longitud }}</td>
                        <td>
                            {{-- Botón Editar --}}
                            <a href="{{ route('ZonasSeguras.edit', $zona->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            {{-- Formulario Eliminar con confirmación SweetAlert --}}
                            <form id="delete-form-{{ $zona->id }}" action="{{ route('ZonasSeguras.destroy', $zona->id) }}" method="POST" style="display:inline-block;">
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

{{-- Script de DataTable --}}
<script>
$(document).ready(function() {
    let table = new DataTable('#zonas-table', {
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

{{-- Confirmación con SweetAlert2 --}}
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
