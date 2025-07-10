@extends('layout.app')

@section('contenido')
<h1 class="text-center">Editar Riesgo</h1>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 bg-white text-black p-4 rounded">
        <form action="{{ route('ZonasRiesgo.update', $riesgo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $riesgo->nombre) }}">
            <br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $riesgo->descripcion) }}</textarea>
            <br>

            <label><b>Nivel de Riesgo:</b></label>
            <input type="text" name="nivel" class="form-control" required value="{{ old('nivel', $riesgo->nivel) }}">
            <br>

            @for($i = 1; $i <= 4; $i++)
            <div class="row mb-4">
                <div class="col-md-5">
                    <label><b>COORDENADA N°{{ $i }}</b></label><br>
                    <label>Latitud</label>
                    <input type="number" step="any" name="latitud{{ $i }}" id="latitud{{ $i }}" class="form-control" readonly value="{{ old("latitud$i", $riesgo->{'latitud' . $i}) }}">
                    <label>Longitud</label>
                    <input type="number" step="any" name="longitud{{ $i }}" id="longitud{{ $i }}" class="form-control" readonly value="{{ old("longitud$i", $riesgo->{'longitud' . $i}) }}">
                </div>
                <div class="col-md-7">
                    <label>&nbsp;</label>
                    <div id="mapa{{ $i }}" style="border:2px solid white; height:200px; width:100%"></div>
                </div>
            </div>
            @endfor

            <center>
                <button class="btn btn-success" type="submit">Actualizar</button>
                &nbsp;&nbsp;&nbsp;
                <a href="{{ route('ZonasRiesgo.index') }}" class="btn btn-danger">Cancelar</a>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" onclick="graficarRiesgo();">Graficar Riesgo</button>
            </center>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid blue;"></div>
    </div>
</div>

<script>
    let mapaPoligono;

    function initMap() {
        const coords = [
            { lat: {{ $riesgo->latitud1 }}, lng: {{ $riesgo->longitud1 }} },
            { lat: {{ $riesgo->latitud2 }}, lng: {{ $riesgo->longitud2 }} },
            { lat: {{ $riesgo->latitud3 }}, lng: {{ $riesgo->longitud3 }} },
            { lat: {{ $riesgo->latitud4 }}, lng: {{ $riesgo->longitud4 }} },
        ];

        coords.forEach((coor, index) => {
            const map = new google.maps.Map(document.getElementById('mapa' + (index + 1)), {
                center: coor,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            const marker = new google.maps.Marker({
                position: coor,
                map: map,
                title: `Seleccione coordenada ${index + 1}`,
                draggable: true
            });

            marker.addListener('dragend', function () {
                document.getElementById('latitud' + (index + 1)).value = this.getPosition().lat();
                document.getElementById('longitud' + (index + 1)).value = this.getPosition().lng();
            });
        });

        mapaPoligono = new google.maps.Map(
            document.getElementById("mapa-poligono"), {
                zoom: 15,
                center: coords[0],
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
    }

    function graficarRiesgo() {
        const coordenadas = [];

        for (let i = 1; i <= 4; i++) {
            const lat = parseFloat(document.getElementById('latitud' + i).value);
            const lng = parseFloat(document.getElementById('longitud' + i).value);
            coordenadas.push(new google.maps.LatLng(lat, lng));
        }

        const poligono = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#00FF00",
            fillOpacity: 0.35,
        });

        poligono.setMap(mapaPoligono);
    }

    window.addEventListener('load', initMap);
</script>

<!-- Script de Google Maps (reemplaza con tu API Key si es diferente) -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAr9nkZqo-8r4BIwIBe09aHs9oYSGqDJwY&callback=initMap">
</script>
@endsection
