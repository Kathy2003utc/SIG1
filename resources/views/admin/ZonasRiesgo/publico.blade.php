@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Zonas de Riesgo</h2>

<div id="map" style="height: 600px; width: 100%; border: 2px solid #2563eb;" class="rounded my-4"></div>

<script>
    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };
        const mapa = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: centro,
            mapTypeId: 'roadmap'
        });

        const zonas = @json($zonas);

        zonas.forEach((zona) => {
            const coordenadas = [
                { lat: parseFloat(zona.latitud1), lng: parseFloat(zona.longitud1) },
                { lat: parseFloat(zona.latitud2), lng: parseFloat(zona.longitud2) },
                { lat: parseFloat(zona.latitud3), lng: parseFloat(zona.longitud3) },
                { lat: parseFloat(zona.latitud4), lng: parseFloat(zona.longitud4) }
            ];

            // Color por nivel de riesgo
            let color = "#00FF00"; // Verde por defecto
            if (zona.nivel.toLowerCase() === 'alto') {
                color = "#FF0000"; // Rojo
            } else if (zona.nivel.toLowerCase() === 'medio') {
                color = "#FFA500"; // Naranja
            }

            // Crear polígono
            const poligono = new google.maps.Polygon({
                paths: coordenadas,
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: color,
                fillOpacity: 0.35,
                map: mapa
            });

            // Crear InfoWindow
            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>${zona.nombre}</strong><br><b>Nivel de riesgo:</b> ${zona.nivel}`
            });

            // Obtener punto central aproximado (puede mejorarse)
            const centroZona = coordenadas[0];

            // Mostrar InfoWindow al pasar el mouse
            poligono.addListener("mouseover", (e) => {
                infoWindow.setPosition(e.latLng);
                infoWindow.open(mapa);
            });

            // Ocultar InfoWindow al quitar el mouse
            poligono.addListener("mouseout", () => {
                infoWindow.close();
            });

            // (Opcional) Agregar marcador con ícono personalizado
            const marker = new google.maps.Marker({
                position: centroZona,
                map: mapa,
                title: zona.nombre,
                icon: {
                    url: '/' + zona.logo_url,
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
        });
    }
</script>


@endsection
