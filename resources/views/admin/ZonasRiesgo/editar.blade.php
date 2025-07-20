@extends('layout.app')

@section('contenido')
<h1 class="text-center mb-4">Editar Riesgo</h1>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <form id="form_riesgo" action="{{ route('admin.ZonasRiesgo.update', $riesgo->id) }}" method="POST" class="card shadow p-4 bg-light">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-3">
                <label for="nombre" class="form-label"><b>Nombre del Riesgo:</b></label>
                <input type="text" id="nombre" name="nombre" class="form-control" required value="{{ old('nombre', $riesgo->nombre) }}">
            </div>

            {{-- Descripción --}}
            <div class="mb-3">
                <label for="descripcion" class="form-label"><b>Descripción:</b></label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $riesgo->descripcion) }}</textarea>
            </div>

            {{-- Nivel de riesgo --}}
            <div class="mb-4">
                <label for="nivel" class="form-label"><b>Nivel de Riesgo:</b></label>
                <select id="nivel" name="nivel" class="form-select" required>
                    <option value="" disabled {{ old('nivel', $riesgo->nivel) ? '' : 'selected' }}>Seleccione un nivel</option>
                    <option value="Alto" {{ old('nivel', $riesgo->nivel) == 'Alto' ? 'selected' : '' }}>ALTO</option>
                    <option value="Medio" {{ old('nivel', $riesgo->nivel) == 'Medio' ? 'selected' : '' }}>MEDIO</option>
                    <option value="Bajo" {{ old('nivel', $riesgo->nivel) == 'Bajo' ? 'selected' : '' }}>BAJO</option>
                </select>
            </div>

            {{-- Coordenadas --}}
            <div class="mb-4">
                <h5><b>Coordenadas (Arrastra los marcadores en el mapa):</b></h5>
                <div class="row g-3">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="col-md-6">
                            <label class="form-label">Coordenada N°{{ $i }}</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Latitud</span>
                                <input type="text" id="latitud{{ $i }}" name="latitud{{ $i }}" class="form-control" value="{{ old('latitud'.$i, $riesgo->{'latitud'.$i}) }}" readonly required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">Longitud</span>
                                <input type="text" id="longitud{{ $i }}" name="longitud{{ $i }}" class="form-control" value="{{ old('longitud'.$i, $riesgo->{'longitud'.$i}) }}" readonly required>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Mapa --}}
            <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid #2563eb;" class="rounded mb-4"></div>

            {{-- Botones --}}
            <div class="text-center">
                <button type="submit" class="btn btn-success me-2">Actualizar</button>
                <a href="{{ route('admin.ZonasRiesgo.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="button" class="btn btn-warning" onclick="reiniciarMapa()">Reiniciar Mapa</button>
            </div>
        </form>
    </div>
</div>

{{-- Google Maps y lógica --}}
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

        const coords = [
            @for ($i = 1; $i <= 4; $i++)
                {
                    lat: "{{ $riesgo->{'latitud'.$i} ?? '' }}",
                    lng: "{{ $riesgo->{'longitud'.$i} ?? '' }}"
                }{{ $i < 4 ? ',' : '' }}
            @endfor
        ]
        .filter(c => c.lat !== '' && c.lng !== '');

        if(coords.length === 0) {
            mapaPoligono.setCenter(centro);
            return;
        }

        mapaPoligono.setCenter({
            lat: parseFloat(coords[0].lat),
            lng: parseFloat(coords[0].lng)
        });

        coords.forEach((coord, idx) => {
            const latNum = parseFloat(coord.lat);
            const lngNum = parseFloat(coord.lng);

            if(isNaN(latNum) || isNaN(lngNum)) return;

            const marker = new google.maps.Marker({
                position: { lat: latNum, lng: lngNum },
                map: mapaPoligono,
                draggable: true,
                label: `${idx + 1}`
            });

            actualizarInputs(idx, marker.getPosition());

            marker.addListener("dragend", () => {
                actualizarInputs(idx, marker.getPosition());
                dibujarPoligono();
            });

            marcadores.push(marker);
        });

        dibujarPoligono();
    }

    function actualizarInputs(idx, latLng) {
        document.getElementById(`latitud${idx + 1}`).value = latLng.lat().toFixed(7);
        document.getElementById(`longitud${idx + 1}`).value = latLng.lng().toFixed(7);
    }

    function dibujarPoligono() {
        if (poligono) poligono.setMap(null);

        if (marcadores.length >= 3) {
            const paths = marcadores.map(m => m.getPosition());
            poligono = new google.maps.Polygon({
                paths: paths,
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

    window.initMap = initMap;
</script>

{{-- Validación con jQuery --}}
<script>
    $(document).ready(function () {
        $("#form_riesgo").validate({
            rules: {
                nombre: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                descripcion: {
                    required: true,
                    minlength: 10,
                    maxlength: 255
                },
                nivel: {
                    required: true
                },
                latitud1: { required: true },
                longitud1: { required: true },
                latitud2: { required: true },
                longitud2: { required: true },
                latitud3: { required: true },
                longitud3: { required: true },
                latitud4: { required: true },
                longitud4: { required: true },
            },
            messages: {
                nombre: {
                    required: "El nombre es obligatorio",
                    minlength: "Debe tener al menos 3 caracteres",
                    maxlength: "Máximo 100 caracteres"
                },
                descripcion: {
                    required: "La descripción es obligatoria",
                    minlength: "Mínimo 10 caracteres",
                    maxlength: "Máximo 255 caracteres"
                },
                nivel: {
                    required: "Seleccione un nivel de riesgo"
                },
                latitud1: { required: "Falta coordenada 1" },
                longitud1: { required: "Falta coordenada 1" },
                latitud2: { required: "Falta coordenada 2" },
                longitud2: { required: "Falta coordenada 2" },
                latitud3: { required: "Falta coordenada 3" },
                longitud3: { required: "Falta coordenada 3" },
                latitud4: { required: "Falta coordenada 4" },
                longitud4: { required: "Falta coordenada 4" }
            },
            submitHandler: function (form) {
                // Validar que no haya coordenadas duplicadas
                const coords = [];
                for (let i = 1; i <= 4; i++) {
                    const lat = $(`#latitud${i}`).val();
                    const lng = $(`#longitud${i}`).val();
                    coords.push(`${lat},${lng}`);
                }

                const uniqueCoords = new Set(coords);
                if (uniqueCoords.size < coords.length) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Coordenadas duplicadas',
                        text: 'No puedes registrar una zona con puntos repetidos.'
                    });
                    return false;
                }

                form.submit();
            }
        });
    });
</script>


@endsection
