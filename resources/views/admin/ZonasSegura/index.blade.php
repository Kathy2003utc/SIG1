@extends('layout.app')

@section('contenido')
<br>
<h1 class="text-center">Listado de Zonas Seguras</h1>
<div class="container mt-4">
    <div class="mx-auto" style="max-width: 1000px;">
        <div class="text-right">
            <a href="{{ route('zonasSeguras.create') }}" class="btn btn-primary">
                Agregar nueva zona segura
            </a>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table">
                    <tr>
                        <th>Nombre</th>
                        <th>Radio</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Tipo de Seguridad</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zonasSeguras as $zona)
                    <tr>
                        <td>{{ $zona->nombre }}</td>
                        <td>{{ $zona->radio }}</td>
                        <td>{{ $zona->latitud }}</td>
                        <td>{{ $zona->longitud }}</td>
                        <td>{{ $zona->tipo_seguridad }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay zonas seguras registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
