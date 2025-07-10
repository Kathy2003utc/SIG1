@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa de Zonas de Riesgo</h2>

<div id="map" style="height: 600px; width:100%; border:2px solid #2563eb;" class="rounded mb-4"></div>

<script>
function initMap() {
    const centro = { lat: -0.9374805, lng: -78.6161327 };
    const mapa = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: centro,
        mapTypeId: 'roadmap'
    });

    // colores por nivel
    const colores = {
        'Alto' : '#e11d48',   // rojo
        'Medio': '#f59e0b',   // naranja
        'Bajo' : '#10b981'    // verde
    };

    const zonas = @json($riesgos);

    zonas.forEach(z => {
        const coords = [
            { lat: parseFloat(z.latitud1), lng: parseFloat(z.longitud1) },
            { lat: parseFloat(z.latitud2), lng: parseFloat(z.longitud2) },
            { lat: parseFloat(z.latitud3), lng: parseFloat(z.longitud3) },
            { lat: parseFloat(z.latitud4), lng: parseFloat(z.longitud4) }
        ];

        const color = colores[z.nivel] ?? '#64748b'; // gris si nivel desconocido

        new google.maps.Polygon({
            paths: coords,
            strokeColor : color,
            strokeOpacity: 0.9,
            strokeWeight : 2,
            fillColor   : color,
            fillOpacity : 0.35,
            map         : mapa
        });

        // Marker + InfoWindow en 1.ª coordenada
        const marker = new google.maps.Marker({
            position: coords[0],
            map,
            title: z.nombre
        });

        const info = new google.maps.InfoWindow({
            content: `<strong>${z.nombre}</strong><br>${z.descripcion}<br><b>Nivel:</b> ${z.nivel}`
        });

        marker.addListener('click', () => info.open(mapa, marker));
    });
}
</script>


@endsection
