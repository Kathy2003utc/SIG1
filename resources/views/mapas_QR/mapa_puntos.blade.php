@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Puntos de Encuentro</h2>

<div id="mapa" style="height: 600px; width: 100%; border: 2px solid #16a34a;" class="rounded my-4"></div>

<script>
    let mapa;
    const centro = { lat: -0.9374805, lng: -78.6161327 };
    const puntos = @json($puntos);

    function initMap() {
        mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: centro,
            zoom: 12,
        });

        puntos.forEach(punto => {
            const pos = {
                lat: parseFloat(punto.latitud),
                lng: parseFloat(punto.longitud)
            };

            const marker = new google.maps.Marker({
                position: pos,
                map: mapa,
                title: punto.nombre
            });

            const infowindow = new google.maps.InfoWindow({
                content: `<strong>${punto.nombre}</strong><br>Capacidad: ${punto.capacidad}<br>Responsable: ${punto.responsable}`
            });

            marker.addListener('click', () => {
                infowindow.open(mapa, marker);
            });
        });
    }

    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdYzugNC_QlesLopg6J4884TRsBzvusjg&callback=initMap">
</script>

@endsection
