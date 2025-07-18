@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Puntos de Encuentro</h2>

<div id="map" style="height: 600px; width: 100%; border: 2px solid #16a34a;" class="rounded my-4"></div>

<script>
    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 }; 
        const mapa = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: centro,
            mapTypeId: 'roadmap'
        });

        const iconoPersonalizado = {
            url: '/images/marker-icon.png', // Ruta de tu ícono
            scaledSize: new google.maps.Size(40, 40)
        };

        const puntos = @json($puntos);

        puntos.forEach(p => {
            const marcador = new google.maps.Marker({
                position: { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) },
                map: mapa,
                title: p.nombre,
                icon: iconoPersonalizado
            });

            const info = new google.maps.InfoWindow({
                content: `<strong>${p.nombre}</strong><br>Responsable: ${p.responsable}<br>Capacidad: ${p.capacidad}`
            });

            marcador.addListener('click', () => info.open(mapa, marcador));
        });
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>
@endsection
