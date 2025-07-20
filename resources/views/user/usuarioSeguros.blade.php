@extends('layout.appUser')
@section('contenido')

<h1 class="text-center mb-5">Mapa de Zonas Seguras</h1>

<div class="container mt-5">
    <h2 class="text-center mb-5">Zonas Seguras Registradas</h2>
    <div class="row">
        @foreach($puntosSeguros as $index => $zona)
        <div class="col-md-4 ftco-animate mb-4">
            <div class="project-wrap card shadow-sm h-100">
                <div class="text p-4">
                    <span class="days">Zona Segura #{{ $index + 1 }}</span>
                    <h3>{{ $zona->nombre }}</h3>
                    <p class="location">
                        <span class="fa fa-map-marker"></span>
                        {{ number_format($zona->latitud, 8) }}, {{ number_format($zona->longitud, 8) }}
                    </p>
                    <ul class="list-unstyled">
                        <li>
                            <span class="fa fa-shield-alt"></span> Tipo: {{ $zona->tipo_seguridad }}
                        </li>
                        <li>
                            <span class="fa fa-circle"></span> Radio: {{ $zona->radio }} metros
                        </li>
                        <li>
                            <span class="fa fa-map-marker"></span>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#zonaModal" 
                                data-lat="{{ $zona->latitud }}"
                                data-lng="{{ $zona->longitud }}"
                                data-nombre="{{ $zona->nombre }}"
                                data-radio="{{ $zona->radio }}">
                                Ver Mapa
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal para mostrar el mapa -->
<div class="modal fade" id="zonaModal" tabindex="-1" aria-labelledby="zonaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="zonaModalLabel">Ubicación de la Zona Segura</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h4 id="zonaNombre"></h4>
        <div id="mapaZona" style="border:2px solid black; height:450px; width:100%;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Script para Google Maps -->
<script type="text/javascript">
    var mapaZona;
    var marcadorZona;
    var circulo;

    function initMapZona(lat, lng, nombre, radio) {
        var centro = new google.maps.LatLng(lat, lng);

        mapaZona = new google.maps.Map(document.getElementById('mapaZona'), {
            center: centro,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        marcadorZona = new google.maps.Marker({
            position: centro,
            map: mapaZona,
            icon: 'https://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/48/Places-user-desktop-icon.png',
            title: nombre,
            draggable: false
        });

        circulo = new google.maps.Circle({
            strokeColor: "#28a745",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#28a745",
            fillOpacity: 0.35,
            map: mapaZona,
            center: centro,
            radius: parseFloat(radio)
        });

        document.getElementById('zonaNombre').textContent = nombre;
    }

    document.getElementById('zonaModal').addEventListener('shown.bs.modal', function(event) {
        var button = event.relatedTarget;
        var lat = parseFloat(button.getAttribute('data-lat'));
        var lng = parseFloat(button.getAttribute('data-lng'));
        var nombre = button.getAttribute('data-nombre');
        var radio = button.getAttribute('data-radio');

        initMapZona(lat, lng, nombre, radio);
    });
</script>


@endsection
