@extends('layout.app')

@section('contenido')
<div class="container">
    <h1 class="mb-4">Editar Punto de Encuentro</h1>

    <form method="POST" action="{{ route('user.puntos.update', $punto->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required value="{{ old('nombre', $punto->nombre) }}">
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" id="capacidad" name="capacidad" class="form-control" min="1" required value="{{ old('capacidad', $punto->capacidad) }}">
        </div>

        <div class="mb-3">
            <label for="responsable" class="form-label">Responsable</label>
            <input type="text" id="responsable" name="responsable" class="form-control" required value="{{ old('responsable', $punto->responsable) }}">
        </div>

        <div class="mb-3">
            <label for="latitud" class="form-label">Latitud</label>
            <input type="text" id="latitud" name="latitud" class="form-control" readonly required value="{{ old('latitud', $punto->latitud) }}">
        </div>

        <div class="mb-3">
            <label for="longitud" class="form-label">Longitud</label>
            <input type="text" id="longitud" name="longitud" class="form-control" readonly required value="{{ old('longitud', $punto->longitud) }}">
        </div>

        <div id="mapa" style="height: 400px; border: 1px solid #ccc;" class="mb-3"></div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('user.puntos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    let mapa;
    let marcador;

    function initMap() {
        const initialPos = {
            lat: parseFloat(document.getElementById('latitud').value) || -0.9374805,
            lng: parseFloat(document.getElementById('longitud').value) || -78.6161327
        };

        mapa = new google.maps.Map(document.getElementById('mapa'), {
            zoom: 15,
            center: initialPos
        });

        marcador = new google.maps.Marker({
            position: initialPos,
            map: mapa,
            draggable: true
        });

        marcador.addListener('dragend', function() {
            const pos = marcador.getPosition();
            document.getElementById('latitud').value = pos.lat().toFixed(7);
            document.getElementById('longitud').value = pos.lng().toFixed(7);
        });
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY_AQUI&callback=initMap"></script>
@endsection
