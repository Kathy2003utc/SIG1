@extends('layout.app')

@section('contenido')
<br>
<h1 class="text-center">Listado de Riesgos</h1>
<div class="container mt-4">
    <div class="mx-auto" style="max-width: 1000px;">
        <div class="text-right">
            <a href="{{ route('ZonasRiesgo.create') }}" class="btn btn-primary">
                Agregar nuevo Riesgo
            </a>
        </div>
        <br>
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
                            <a href="{{ route('riesgos.edit', $riesgo->id) }}" class="btn btn-sm btn-primary me-1">Editar</a>

                            <form action="{{ route('riesgos.destroy', $riesgo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este riesgo?')">
                                    Eliminar
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
@endsection
