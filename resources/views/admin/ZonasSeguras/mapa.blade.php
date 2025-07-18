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

            // Elegir color según el tipo de seguridad
            let color = "#10b981"; // color por defecto (verde)
            switch (zona.tipo_seguridad.toLowerCase()) {
                case 'refugio':
                    color = "#3b82f6"; // azul
                    break;
                case 'zona de evacuacion':
                    color = "#f59e0b"; // amarillo
                    break;
                case 'centro de salud':
                    color = "#ef4444"; // rojo
                    break;
            }

            const circulo = new google.maps.Circle({
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: color,
                fillOpacity: 0.35,
                map: mapa,
                center: centro,
                radius: radio
            });

            const info = new google.maps.InfoWindow({
                content: `
                <div style="font-family: Arial; font-size: 14px; max-width: 250px;">
                    <h6 style="margin: 0 0 5px 0; color: #111;">${zona.nombre}</h6>
                    <p style="margin: 0;"><strong>Tipo:</strong> ${zona.tipo_seguridad}</p>
                    <p style="margin: 0;"><strong>Radio:</strong> ${zona.radio} m</p>
                </div>
                `
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
