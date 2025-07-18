@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Zonas Seguras</h2>

<div id="map" style="height: 600px; width: 100%; border: 2px solid #22c55e;" class="rounded my-4"></div>

<script>
    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };
        const mapa = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: centro,
            mapTypeId: 'roadmap'
        });

        const zonas = @json($zonas);

        zonas.forEach(zona => {
            const radio = parseFloat(zona.radio);
            const centro = { lat: parseFloat(zona.latitud), lng: parseFloat(zona.longitud) };

            const circulo = new google.maps.Circle({
                strokeColor: "#10b981",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#10b981",
                fillOpacity: 0.35,
                map: mapa,
                center: centro,
                radius: radio
            });

            const info = new google.maps.InfoWindow({
                content: `<strong>${zona.nombre}</strong><br>Tipo: ${zona.tipo_seguridad}<br>Radio: ${zona.radio} m`
            });

            const marcador = new google.maps.Marker({
                position: centro,
                map: mapa,
                title: zona.nombre
            });

            marcador.addListener('click', () => info.open(mapa, marcador));
        });
    }
</script>


@endsection
