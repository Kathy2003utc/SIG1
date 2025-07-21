@extends('layout.app')

@section('contenido')
<h2 class="text-center mt-3">Mapa Público de Zonas Seguras</h2>

<!-- Filtro debajo del título, alineado a la derecha -->
<div class="d-flex justify-content-end align-items-center mb-3" style="max-width: 400px; margin-left: auto; margin-right: 20px;">
    <label for="filtroTipo" class="me-2 mb-0 fw-semibold">Filtrar por tipo de seguridad:</label>
    <select id="filtroTipo" class="form-select form-select-sm" style="width: 180px;">
        <option value="todos" selected>Todos</option>
        <option value="Refugio">Refugio</option>
        <option value="Zona de evacuacion">Zona de evacuacion</option>
        <option value="Centro de salud">Centro de salud</option>
    </select>
</div>

<!-- Contenedor del mapa con borde y bordes redondeados -->
<div style="border: 2px solid #22c55e; border-radius: 8px; overflow: hidden;">
    <div id="map" style="height: 600px; width: 100%;"></div>
</div>

<script>
    let mapa;
    let circulos = [];
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

        document.getElementById('filtroTipo').addEventListener('change', function() {
            renderZonas(this.value);
        });
    }

    function clearMap() {
        circulos.forEach(c => c.setMap(null));
        circulos = [];

        markers.forEach(m => m.setMap(null));
        markers = [];
    }

    function renderZonas(filtro) {
        clearMap();

        const zonasFiltradas = filtro === 'todos'
            ? zonas
            : zonas.filter(z => z.tipo_seguridad.toLowerCase() === filtro.toLowerCase());

        zonasFiltradas.forEach(zona => {
            const radio = parseFloat(zona.radio);
            const centroZona = { lat: parseFloat(zona.latitud), lng: parseFloat(zona.longitud) };

            let color = "#10b981"; // verde por defecto
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
                center: centroZona,
                radius: radio
            });
            circulos.push(circulo);

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
                position: centroZona,
                map: mapa,
                title: zona.nombre
            });
            markers.push(marcador);

            marcador.addListener('click', () => info.open(mapa, marcador));
        });
    }

    window.initMap = initMap;
</script>

@endsection
