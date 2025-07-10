@extends('layout.app')

@section('contenido')

    <h1 class="text-center">Nueva Zona Segura</h1><br>

    <form action="{{ route('ZonasSeguras.store') }}" method="POST" id="frm_nueva_zona_segura">
        @csrf

        <label for=""><b>Nombre:</b></label><br>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre de la zona"><br>

        <label for=""><b>Tipo de Seguridad:</b></label><br>
        <select name="tipo_seguridad" id="tipo_seguridad" class="form-control">
            <option value="">--Seleccione--</option>
            <option value="Refugio">Refugio</option>
            <option value="Zona de evacuación">Zona de evacuación</option>
            <option value="Centro de salud">Centro de salud</option>
        </select>
        <br>

        <label for=""><b>Radio (en metros):</b></label><br>
        <input type="number" name="radio" id="radio" class="form-control" placeholder="Ingrese el radio de seguridad"><br>

        <div class="row">
            <div class="col-md-6">
                <label for=""><b>Latitud:</b></label><br>
                <input type="text" name="latitud" id="latitud" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for=""><b>Longitud:</b></label><br>
                <input type="text" name="longitud" id="longitud" class="form-control" readonly>
            </div>
        </div>

        <br><label for=""><b>Ubicación de la Zona Segura:</b></label><br>
        <div id="mapa1" style="border:2px solid black; height:300px; width:100%;"></div>
        <br>

        <button class="btn btn-success">Guardar</button>
        &nbsp; &nbsp;
        <button type="button" onclick="graficarCirculo()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo">Graficar</button>
        &nbsp; &nbsp;
        <a href="{{ route('ZonasSeguras.index') }}" class="btn btn-danger">Cancelar</a>

    </form>

    <!-- Modal -->
    <div class="modal fade" id="modalGraficoCirculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Rango de Seguridad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="mapa-circulo" style="border:2px solid blue; height:300px; width:100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var mapa;
        function initMap() {
            var latLngInicial = new google.maps.LatLng(-0.9374805, -78.6161327);
            mapa = new google.maps.Map(document.getElementById('mapa1'), {
                center: latLngInicial,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var marcador = new google.maps.Marker({
                position: latLngInicial,
                map: mapa,
                title: "Ubicación de la zona segura",
                draggable: true
            });

            google.maps.event.addListener(marcador, 'dragend', function () {
                var lat = this.getPosition().lat();
                var lng = this.getPosition().lng();
                document.getElementById("latitud").value = lat;
                document.getElementById("longitud").value = lng;
            });
        }

        function graficarCirculo(){
            var radio = document.getElementById('radio').value;
            var latitud = document.getElementById('latitud').value;
            var longitud = document.getElementById('longitud').value;

            var centro = new google.maps.LatLng(latitud, longitud);

            var mapaCirculo = new google.maps.Map(document.getElementById('mapa-circulo'), {
                center: centro,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.SATELLITE
            });

            new google.maps.Marker({
                position: centro,
                map: mapaCirculo,
                title: "Centro de la zona",
                draggable: false
            });

            new google.maps.Circle({
                strokeColor: "red",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "blue",
                fillOpacity: 0.5,
                map: mapaCirculo,
                center: centro,
                radius: parseFloat(radio)
            });
        }
    </script>
@endsection
