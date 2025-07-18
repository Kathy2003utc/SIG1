@extends('layout.app')

@section('contenido')
<h1 class="text-center">Editar Riesgo</h1>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <form action="{{ route('user.ZonasRiesgo.update', $riesgo->id) }}" method="POST" class="card shadow p-4 bg-light">
            @csrf
            @method('PUT')

            {{-- Datos generales --}}
            <label><b>Nombre del Riesgo:</b></label>
            <input type="text" name="nombre" class="form-control" required value="{{ $riesgo->nombre }}">
            <br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" class="form-control" required>{{ $riesgo->descripcion }}</textarea>
            <br>

            <label class="form-label"><b>Nivel de Riesgo:</b></label>
            <select name="nivel" class="form-select" required>
                <option value="" disabled>Seleccione un nivel</option>
                <option value="Alto" {{ $riesgo->nivel == 'Alto' ? 'selected' : '' }}>ALTO</option>
                <option value="Medio" {{ $riesgo->nivel == 'Medio' ? 'selected' : '' }}>MEDIO</option>
                <option value="Bajo" {{ $riesgo->nivel == 'Bajo' ? 'selected' : '' }}>BAJO</option>
            </select>

            {{-- Inputs coordenadas --}}
            @for ($i = 1; $i <= 4; $i++)
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label><b>Coordenada N°{{ $i }}</b></label>
                        <div class="input-group mb-2">
                            <span class="input-group-text">Latitud</span>
                            <input type="text" id="latitud{{ $i }}" name="latitud{{ $i }}" class="form-control" value="{{ $riesgo->{'latitud'.$i} }}" readonly>
                            <br><br>
                            <span class="input-group-text">Longitud</span>
                            <input type="text" id="longitud{{ $i }}" name="longitud{{ $i }}" class="form-control" value="{{ $riesgo->{'longitud'.$i} }}" readonly>
                        </div>
                    </div>
                </div>
            @endfor

            {{-- Mapa principal --}}
            <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid #2563eb;" class="rounded mb-4"></div>

            <center>
                <button class="btn btn-success">Actualizar</button>
                &nbsp;&nbsp;
                <a href="{{ route('user.ZonasRiesgo.index') }}" class="btn btn-secondary">Cancelar</a>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-warning" onclick="reiniciarMapa()">Reiniciar Mapa</button>
            </center>
        </form>
    </div>
</div>

<script>
    let mapaPoligono;
    let marcadores = [];
    let poligono = null;

    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };

        mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
            center: centro,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Carga coordenadas existentes
        const coords = [];
        @for ($i = 1; $i <= 4; $i++)
            coords.push({
                lat: parseFloat({{ $riesgo->{'latitud'.$i} }}),
                lng: parseFloat({{ $riesgo->{'longitud'.$i} }})
            });
        @endfor

        coords.forEach((coord, index) => {
            const marker = new google.maps.Marker({
                position: coord,
                map: mapaPoligono,
                draggable: true,
                label: `${index + 1}`
            });

            setInputs(index, coord);

            marker.addListener("dragend", () => {
                setInputs(index, marker.getPosition());
                dibujarPoligono();
            });

            marcadores.push(marker);
        });

        dibujarPoligono();
    }

    function setInputs(idx, latLng) {
        document.getElementById(`latitud${idx + 1}`).value = latLng.lat().toFixed(7);
        document.getElementById(`longitud${idx + 1}`).value = latLng.lng().toFixed(7);
    }

    function dibujarPoligono() {
        if (poligono) poligono.setMap(null);

        if (marcadores.length >= 3) {
            const coords = marcadores.map(m => m.getPosition());
            poligono = new google.maps.Polygon({
                paths: coords,
                strokeColor: "#ff0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#00ff00",
                fillOpacity: 0.35,
                map: mapaPoligono
            });
        }
    }

    function reiniciarMapa() {
        marcadores.forEach(m => m.setMap(null));
        marcadores = [];
        if (poligono) poligono.setMap(null);
        poligono = null;

        for (let i = 1; i <= 4; i++) {
            document.getElementById(`latitud${i}`).value = '';
            document.getElementById(`longitud${i}`).value = '';
        }
    }

    window.addEventListener('load', initMap);
</script>
@endsection
