@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Zonas de Riesgo</h2>

<div id="map" style="height: 600px; width: 100%; border: 2px solid #2563eb;" class="rounded my-4"></div>

<script>
    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 }; // Cambia por tu centro real
        const mapa = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: centro,
            mapTypeId: 'roadmap'
        });

        // Polígonos desde la base de datos
        const zonas = @json($zonas);

        zonas.forEach((zona, idx) => {
            const coordenadas = [
                { lat: parseFloat(zona.latitud1), lng: parseFloat(zona.longitud1) },
                { lat: parseFloat(zona.latitud2), lng: parseFloat(zona.longitud2) },
                { lat: parseFloat(zona.latitud3), lng: parseFloat(zona.longitud3) },
                { lat: parseFloat(zona.latitud4), lng: parseFloat(zona.longitud4) }
            ];

            const poligono = new google.maps.Polygon({
                paths: coordenadas,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map: mapa
            });

            const centroZona = coordenadas[0];
            const info = new google.maps.InfoWindow({
                content: `<strong>${zona.nombre}</strong><br>${zona.descripcion}<br><b>Nivel:</b> ${zona.nivel}`
            });

            const marker = new google.maps.Marker({
                position: centroZona,
                map: mapa,
                title: zona.nombre
            });

            marker.addListener('click', () => info.open(mapa, marker));
        });
    }
</script>


@endsection
