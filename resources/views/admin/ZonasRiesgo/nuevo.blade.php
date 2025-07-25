@extends('layout.app')

@section('contenido')
<h1 class="text-center">Registrar nuevo Riesgo</h1>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <form id="form_riesgo" action="{{ route('admin.ZonasRiesgo.store') }}" method="POST" class="card shadow p-4 bg-light">
            @csrf

            {{-- Datos generales --}}
            <label><b>Nombre del Riesgo:</b></label>
            <input type="text" name="nombre" class="form-control" required placeholder="Nombre del riesgo">
            <br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" class="form-control" required placeholder="Describe el riesgo…"></textarea>
            <br>

            <label class="form-label"><b>Nivel de Riesgo:</b></label>
            <select name="nivel" class="form-select" required>
                <option value="" disabled selected>Seleccione un nivel</option>
                <option value="Alto">ALTO</option>
                <option value="Medio">MEDIO</option>
                <option value="Bajo">BAJO</option>
            </select>

            {{-- Inputs coordenadas --}}
            @for ($i = 1; $i <= 4; $i++)
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label><b>Coordenada N°{{ $i }}</b></label>
                        <div class="input-group mb-2">
                            <span class="input-group-text">Latitud</span>
                            <input type="text" id="latitud{{ $i }}" name="latitud{{ $i }}" class="form-control" readonly>
                            <br><br>
                            <span class="input-group-text">Longitud</span>
                            <input type="text" id="longitud{{ $i }}" name="longitud{{ $i }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            @endfor

            {{-- Mapa principal --}}
            <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid #2563eb;" class="rounded mb-4"></div>

            <center>
                <button class="btn btn-success">Guardar</button>
                &nbsp;&nbsp;
                <a href="{{ route('admin.ZonasRiesgo.index') }}" class="btn btn-secondary">Cancelar</a>
                &nbsp;&nbsp;
                <button type="reset" class="btn btn-danger" onclick="reiniciarMapa()">Limpiar</button>
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

        // Al hacer clic se agrega un marcador (máx. 4)
        mapaPoligono.addListener("click", (e) => {
            if (marcadores.length >= 4) {
                Swal.fire({
                    icon: 'info',
                    title: 'Máximo 4 puntos',
                    text: 'Ya definiste las 4 coordenadas de la zona.'
                });
                return;
            }

            const index = marcadores.length;
            const marker = new google.maps.Marker({
                position: e.latLng,
                map: mapaPoligono,
                draggable: true,
                label: `${index + 1}`
            });

            // Actualiza inputs
            setInputs(index, marker.getPosition());

            // Al arrastrar el marcador…
            marker.addListener("dragend", () => {
                setInputs(index, marker.getPosition());
                dibujarPoligono();
            });

            marcadores.push(marker);
            dibujarPoligono();
        });
    }

    /* ---------- utilidades ---------- */
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
        // Elimina marcadores y polígono
        marcadores.forEach(m => m.setMap(null));
        marcadores = [];
        if (poligono) poligono.setMap(null);
        poligono = null;

        // Limpia inputs
        for (let i = 1; i <= 4; i++) {
            document.getElementById(`latitud${i}`).value = '';
            document.getElementById(`longitud${i}`).value = '';
        }
    }
</script>

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
                // Validación adicional para evitar zonas duplicadas
                const coords = [];
                for (let i = 1; i <= 4; i++) {
                    let lat = $(`#latitud${i}`).val();
                    let lng = $(`#longitud${i}`).val();
                    coords.push(`${lat},${lng}`);
                }

                let duplicado = false;
                const coordsUnicas = new Set(coords);
                if (coordsUnicas.size < coords.length) {
                    duplicado = true;
                }

                if (duplicado) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Coordenadas duplicadas',
                        text: 'No puedes registrar una zona con puntos repetidos.'
                    });
                    return false;
                }

                // Si todo está OK, enviar el formulario
                form.submit();
            }
        });
    });
</script>


@endsection
