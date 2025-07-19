@extends('layout.appUser')
@section('contenido')
<h1>BIENVENIDO AL MAPA</h1>

<div class="container mt-5">
    <h2 class="text-center mb-5">Puntos de Encuentro Disponibles</h2>
    <div class="row">
        @foreach($puntoEncuentros as $index => $puntoTemp)
        <div class="col-md-4 ftco-animate mb-4">
            <div class="project-wrap card shadow-sm h-100 ">
                <div class="text p-4">
                    <span class="days">Punto de Encuentro #{{ $index + 1 }}</span>
                    <h3>{{ $puntoTemp->nombre }}</h3>
                    <p class="location">
                        <span class="fa fa-map"></span> 
                        {{ number_format($puntoTemp->latitud, 8) }}, {{ number_format($puntoTemp->longitud, 8) }}
                    </p>
                    <ul class="list-unstyled">
                        <li style="color: inherit;">
                            <span class="fa fa-users"></span> Capacidad: {{ $puntoTemp->capacidad }} personas
                        </li>
                        <li style="color: inherit; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;">
                            <span class="fa fa-user"></span> Responsable: {{ $puntoTemp->responsable }}
                        </li>
                        <li>
                            <span class="fa fa-map-marker"></span> 
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#puntoModal" 
                            data-lat="{{$puntoTemp->latitud}}"
                            data-lng="{{$puntoTemp->longitud}}"
                            data-nombre="{{$puntoTemp->nombre}}">
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
<div class="modal fade" id="puntoModal" tabindex="-1" aria-labelledby="puntoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="puntoModalLabel">Ubicación del punto de encuentro</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 id="puntoNombre"></h4>
        <div id="mapaPunto" style="border:2px solid black; height:450px; width:100%;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var mapa;
    var marcadorActual;

    function initMap(lat, lng, nombre) {
        var latitud_longitud= new google.maps.LatLng(lat,lng);
        
        mapa=new google.maps.Map(
          document.getElementById('mapaPunto'),
          {
            center:latitud_longitud,
            zoom:12,
            mapTypeId:google.maps.MapTypeId.ROADMAP
          }
        );
        
        marcadorActual=new google.maps.Marker({
          position:latitud_longitud,
          map:mapa,
          icon:'https://icons.iconarchive.com/icons/hopstarter/sleek-xp-basic/48/User-Group-icon.png',
          title:nombre,
          draggable:false
        });
        document.getElementById('puntoNombre').textContent = nombre;
    }

    // Evento cuando se muestra el modal segun los datos del punto de encuentro kiubo
    document.getElementById('puntoModal').addEventListener('shown.bs.modal', function(event) {
        var button = event.relatedTarget;
        var lat = parseFloat(button.getAttribute('data-lat'));
        var lng = parseFloat(button.getAttribute('data-lng'));
        var nombre = button.getAttribute('data-nombre');
        
        initMap(lat, lng, nombre);
    });
    window.onload = function() {
        initMap();
    }
</script>
@endsection