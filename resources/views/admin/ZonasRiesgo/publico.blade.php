@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Zonas de Riesgo</h2>

<!-- Filtro debajo del título, alineado a la derecha -->
<div class="d-flex justify-content-end align-items-center mb-3" style="max-width: 400px; margin-left: auto; margin-right: 20px;">
    <label for="filtroNivel" class="me-2 mb-0 fw-semibold">Filtrar por nivel de riesgo:</label>
    <select id="filtroNivel" class="form-select form-select-sm" style="width: 150px;">
        <option value="todos" selected>Todos</option>
        <option value="Alto">Alto</option>
        <option value="Medio">Medio</option>
        <option value="Bajo">Bajo</option>
    </select>
</div>

<!-- Contenedor del mapa con borde y borde redondeado -->
<div style="border: 2px solid #2563eb; border-radius: 8px; overflow: hidden;">
    <div id="map" style="height: 600px; width: 100%;"></div>
</div>

<script>
    let mapa;
    let poligonos = [];
    let markers = [];
    const zonas = @json($zonas);

    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };
        mapa = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: centro,
            mapTypeId: 'roadmap'
        });

        renderZonas('todos');

        document.getElementById('filtroNivel').addEventListener('change', function() {
            renderZonas(this.value);
        });
    }

    function clearMap() {
        poligonos.forEach(p => p.setMap(null));
        poligonos = [];

        markers.forEach(m => m.setMap(null));
        markers = [];
    }

    function renderZonas(filtro) {
        clearMap();

        const zonasFiltradas = filtro === 'todos'
            ? zonas
            : zonas.filter(z => z.nivel.toLowerCase() === filtro.toLowerCase());

        zonasFiltradas.forEach((zona) => {
            const coordenadas = [
                { lat: parseFloat(zona.latitud1), lng: parseFloat(zona.longitud1) },
                { lat: parseFloat(zona.latitud2), lng: parseFloat(zona.longitud2) },
                { lat: parseFloat(zona.latitud3), lng: parseFloat(zona.longitud3) },
                { lat: parseFloat(zona.latitud4), lng: parseFloat(zona.longitud4) }
            ];

            let color = "#00FF00";
            if (zona.nivel.toLowerCase() === 'alto') color = "#FF0000";
            else if (zona.nivel.toLowerCase() === 'medio') color = "#FFA500";

            const poligono = new google.maps.Polygon({
                paths: coordenadas,
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: color,
                fillOpacity: 0.35,
                map: mapa
            });
            poligonos.push(poligono);

            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>${zona.nombre}</strong><br><b>Nivel de riesgo:</b> ${zona.nivel}`
            });

            const centroZona = coordenadas[0];

            poligono.addListener("mouseover", (e) => {
                infoWindow.setPosition(e.latLng);
                infoWindow.open(mapa);
            });

            poligono.addListener("mouseout", () => {
                infoWindow.close();
            });

            if(zona.logo_url) {
                const marker = new google.maps.Marker({
                    position: centroZona,
                    map: mapa,
                    title: zona.nombre,
                    icon: {
                        url: '/' + zona.logo_url,
                        scaledSize: new google.maps.Size(40, 40)
                    }
                });
                markers.push(marker);
            }
        });
    }

    window.initMap = initMap;
</script>

@endsection
