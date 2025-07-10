@extends('layout.app')

@section('contenido')
<br>
<h1 class="text-center">Listado de Riesgos</h1>

<div class="container mt-4">
    <div class="mx-auto" style="max-width: 1000px;">
        <<a href="{{ route('ZonasRiesgo.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus-circle"></i> Nueva Zona de riesgo
        </a>
    
        <a href="#" class="btn btn-primary mb-3">
            <i class="fas fa-map"></i> Vista previa del reporte
        </a>

        <br>

        {{-- Mensaje de éxito con SweetAlert --}}
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
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Nivel</th>
                        <th>Coordenada N°1</th>
                        <th>Coordenada N°2</th>
                        <th>Coordenada N°3</th>
                        <th>Coordenada N°4</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riesgos as $riesgo)
                    <tr>
                        <td>{{ $riesgo->nombre }}</td>
                        <td>{{ $riesgo->descripcion }}</td>
                        <td>{{ $riesgo->nivel }}</td>
                        <td>Latitud: {{ $riesgo->latitud1 }}<br>Longitud: {{ $riesgo->longitud1 }}</td>
                        <td>Latitud: {{ $riesgo->latitud2 }}<br>Longitud: {{ $riesgo->longitud2 }}</td>
                        <td>Latitud: {{ $riesgo->latitud3 }}<br>Longitud: {{ $riesgo->longitud3 }}</td>
                        <td>Latitud: {{ $riesgo->latitud4 }}<br>Longitud: {{ $riesgo->longitud4 }}</td>
                        <td class="text-center">
                            {{-- Botón Editar --}}
                            <a href="{{ route('ZonasRiesgo.edit', $riesgo->id) }}" class="btn btn-sm btn-primary me-1">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            {{-- Botón Eliminar con SweetAlert --}}
                            <form action="{{ route('ZonasRiesgo.destroy', $riesgo->id) }}" method="POST" class="d-inline eliminar-formulario">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
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

{{-- Script SweetAlert para confirmar eliminación --}}
<script>
document.querySelectorAll('.eliminar-formulario').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>


@endsection
