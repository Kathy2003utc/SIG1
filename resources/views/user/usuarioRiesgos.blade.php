@extends('layout.appUser')
@section('contenido')

<h1 class="text-center mb-5">Mapa de Zonas de Riesgo</h1>

<div class="container mt-5">
    <h2 class="text-center mb-5">Zonas de Riesgo Registradas</h2>
    <div class="row">
        @foreach($puntosRiesgo as $index => $riesgo)
        <div class="col-md-4 ftco-animate mb-4">
            <div class="project-wrap card shadow-sm h-100">
                <div class="text p-4">
                    <span class="days">Zona de Riesgo #{{ $index + 1 }}</span>
                    <h3>{{ $riesgo->nombre }}</h3>
                    <p>
                        <span class="fa fa-exclamation-triangle"></span>
                        Nivel: {{ $riesgo->nivel }}
                    </p>
                    <p>{{ $riesgo->descripcion }}</p>
                    <button 
                        class="btn btn-danger btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#riesgoModal" 
                        data-nombre="{{ $riesgo->nombre }}"
                        data-nivel="{{ $riesgo->nivel }}"
                        data-descripcion="{{ $riesgo->descripcion }}"
                        data-lat1="{{ $riesgo->latitud1 }}"
                        data-lng1="{{ $riesgo->longitud1 }}"
                        data-lat2="{{ $riesgo->latitud2 }}"
                        data-lng2="{{ $riesgo->longitud2 }}"
                        data-lat3="{{ $riesgo->latitud3 }}"
                        data-lng3="{{ $riesgo->longitud3 }}"
                        data-lat4="{{ $riesgo->latitud4 }}"
                        data-lng4="{{ $riesgo->longitud4 }}">
                        Ver Mapa
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="riesgoModal" tabindex="-1" aria-labelledby="riesgoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="riesgoModalLabel">Zona de Riesgo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h4 id="riesgoNombre"></h4>
        <p id="riesgoDescripcion"></p>
        <div id="mapaRiesgo" style="height: 450px; border: 2px solid black; width: 100%;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Script de Google Maps -->
<script type="text/javascript">
    var mapa;
    var poligono;

    function mostrarZonaRiesgo(coords, nombre, descripcion) {
        var bounds = new google.maps.LatLngBounds();

        mapa = new google.maps.Map(document.getElementById('mapaRiesgo'), {
            zoom: 15,
            center: coords[0],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        poligono = new google.maps.Polygon({
            paths: coords,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35
        });

        poligono.setMap(mapa);

        // Centrar mapa en el área del polígono
        coords.forEach(function(coord) {
            bounds.extend(coord);
        });
        mapa.fitBounds(bounds);

        document.getElementById('riesgoNombre').textContent = nombre;
        document.getElementById('riesgoDescripcion').textContent = descripcion;
    }

    document.getElementById('riesgoModal').addEventListener('shown.bs.modal', function(event) {
        var button = event.relatedTarget;

        var nombre = button.getAttribute('data-nombre');
        var descripcion = button.getAttribute('data-descripcion');

        var coords = [
            { lat: parseFloat(button.getAttribute('data-lat1')), lng: parseFloat(button.getAttribute('data-lng1')) },
            { lat: parseFloat(button.getAttribute('data-lat2')), lng: parseFloat(button.getAttribute('data-lng2')) },
            { lat: parseFloat(button.getAttribute('data-lat3')), lng: parseFloat(button.getAttribute('data-lng3')) },
            { lat: parseFloat(button.getAttribute('data-lat4')), lng: parseFloat(button.getAttribute('data-lng4')) }
        ];

        mostrarZonaRiesgo(coords, nombre, descripcion);
    });
</script>


@endsection
