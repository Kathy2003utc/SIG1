@extends('layout.app')

@section('contenido')
<h1 class="text-center">Registrar nuevo Riesgo</h1>
<div class="row justify-content-center">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('ZonasRiesgo.store') }}" method="POST">
            @csrf
            <label><b>Nombre del Riesgo:</b></label>
            <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre del riesgo" required class="form-control">
            <br>
            <label><b>Descripción:</b></label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Describa el riesgo..." required></textarea>
            <br>
            <label><b>Nivel de Riesgo:</b></label>
            <input type="text" name="nivel" id="nivel" placeholder="Alto, Medio o Bajo" required class="form-control">
            <br>

            @for($i = 1; $i <= 4; $i++)
            <div class="row mb-4">
                <div class="col-md-5">
                    <label><b>COORDENADA N°{{ $i }}</b></label><br><br>
                    <label>Latitud</label>
                    <input type="number" name="latitud{{ $i }}" id="latitud{{ $i }}" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                    <label>Longitud</label>
                    <input type="number" name="longitud{{ $i }}" id="longitud{{ $i }}" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                </div>
                <div class="col-md-7">
                    <div id="mapa{{ $i }}" style="border:2px solid white; height:200px;width:100%"></div>
                </div>
            </div>
            @endfor

            <center>
                <button class="btn btn-success">Guardar</button>
                &nbsp;&nbsp;
                <a href="{{ route('ZonasRiesgo.index') }}" class="btn btn-secondary">Cancelar</a>
                &nbsp;&nbsp;
                <button type="reset" class="btn btn-danger">Limpiar</button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-primary" onclick="graficarRiesgo();">Graficar Riesgo</button>
            </center>
        </form>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid blue;"></div>
    </div>
</div>

<script>
    var mapaPoligono;

    function initMap() {
        const defaultLocation = new google.maps.LatLng(-0.9374805, -78.6161327);

        for (let i = 1; i <= 4; i++) {
            const mapa = new google.maps.Map(document.getElementById('mapa' + i), {
                center: defaultLocation,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            const marcador = new google.maps.Marker({
                position: defaultLocation,
                map: mapa,
                title: `Seleccione coordenada ${i}`,
                draggable: true
            });

            google.maps.event.addListener(marcador, 'dragend', function () {
                document.getElementById('latitud' + i).value = this.getPosition().lat();
                document.getElementById('longitud' + i).value = this.getPosition().lng();
            });
        }

        mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
            zoom: 15,
            center: defaultLocation,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
    }

    function graficarRiesgo() {
        const coordenadas = [];
        for (let i = 1; i <= 4; i++) {
            const lat = parseFloat(document.getElementById('latitud' + i).value);
            const lng = parseFloat(document.getElementById('longitud' + i).value);
            if (!isNaN(lat) && !isNaN(lng)) {
                coordenadas.push(new google.maps.LatLng(lat, lng));
            }
        }

        const poligono = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#00FF00",
            fillOpacity: 0.35
        });

        poligono.setMap(mapaPoligono);
    }

    window.addEventListener('load', initMap);
</script>

@endsection
