@extends('layout.app')

@section('contenido')

<br><br><br><br><br>
<div class='row'>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form id="frm_zona_segura" action="{{ route('admin.ZonasSeguras.update', $zona) }}" method="POST">
            @csrf
            @method('PUT')
            <h3><b>Editar Zona Segura</b></h3>
            <hr>

            <label for="nombre"><b>Nombre de la zona:</b></label>
            <input type="text" name="nombre" id="nombre" value="{{ $zona->nombre }}" class="form-control" required>

            <label for="tipo_seguridad"><b>Tipo de seguridad:</b></label>
            <select name="tipo_seguridad" id="tipo_seguridad" class="form-select" required>
                <option value="">--- Seleccione ---</option>
                <option value="Refugio" {{ $zona->tipo_seguridad == 'Refugio' ? 'selected' : '' }}>Refugio</option>
                <option value="Zona de evacuación" {{ $zona->tipo_seguridad == 'Zona de evacuación' ? 'selected' : '' }}>Zona de evacuación</option>
                <option value="Centro de salud" {{ $zona->tipo_seguridad == 'Centro de salud' ? 'selected' : '' }}>Centro de salud</option>
            </select>

            <label for="radio"><b>Radio (en metros):</b></label>
            <input type="number" name="radio" id="radio" value="{{ $zona->radio }}" class="form-control" required>

            <label><b>Coordenadas centrales:</b></label>
            <input type="text" name="latitud" id="latitud" value="{{ $zona->latitud }}" class="form-control" readonly required>
            <input type="text" name="longitud" id="longitud" value="{{ $zona->longitud }}" class="form-control" readonly required>

            <div id="mapa2" style="height: 300px; width: 100%; border: 3px solid #2563eb; margin-top: 15px; border-radius: 6px;"></div>

            <br>
            <center>
                <a href="{{ route('admin.ZonasSeguras.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Actualizar Zona</button>
            </center>
        </form>
    </div>
</div>

<script>
function initMap() {
    const defaultCoords = {
        lat: parseFloat(document.getElementById('latitud').value),
        lng: parseFloat(document.getElementById('longitud').value)
    };

    const mapa = new google.maps.Map(document.getElementById('mapa2'), {
        center: defaultCoords,
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const marker = new google.maps.Marker({
        position: defaultCoords,
        map: mapa,
        draggable: true,
        title: "Arrastra para mover la zona segura"
    });

    const circle = new google.maps.Circle({
        strokeColor: "#10b981",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#34d399",
        fillOpacity: 0.4,
        map: mapa,
        center: defaultCoords,
        radius: parseFloat(document.getElementById('radio').value || 100),
    });

    marker.addListener('drag', function () {
        const pos = marker.getPosition();
        document.getElementById('latitud').value = pos.lat().toFixed(7);
        document.getElementById('longitud').value = pos.lng().toFixed(7);
        circle.setCenter(pos);
    });

    document.getElementById('radio').addEventListener('input', function () {
        const nuevoRadio = parseFloat(this.value);
        if (!isNaN(nuevoRadio)) {
            circle.setRadius(nuevoRadio);
        }
    });

    const actualizarDesdeInputs = () => {
        const lat = parseFloat(document.getElementById('latitud').value);
        const lng = parseFloat(document.getElementById('longitud').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const nuevaPos = new google.maps.LatLng(lat, lng);
            marker.setPosition(nuevaPos);
            circle.setCenter(nuevaPos);
            mapa.setCenter(nuevaPos);
        }
    };

    document.getElementById('latitud').addEventListener('change', actualizarDesdeInputs);
    document.getElementById('longitud').addEventListener('change', actualizarDesdeInputs);
}


</script>
<script>
    $(document).ready(function () {
        $("#frm_zona_segura").validate({
            rules: {
                nombre: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                tipo_seguridad: {
                    required: true
                },
                radio: {
                    required: true,
                    number: true,
                    min: 10,
                    max: 1000
                },
                latitud: {
                    required: true
                },
                longitud: {
                    required: true
                }
            },
            messages: {
                nombre: {
                    required: "El nombre es obligatorio",
                    minlength: "Debe tener al menos 3 caracteres",
                    maxlength: "Máximo 50 caracteres"
                },
                tipo_seguridad: {
                    required: "Debe seleccionar el tipo de seguridad"
                },
                radio: {
                    required: "Debe ingresar un radio",
                    number: "Debe ser un número",
                    min: "El radio mínimo debe ser 10 metros",
                    max: "El radio máximo permitido es 1000 metros"
                },
                latitud: {
                    required: "Debe seleccionar una ubicación en el mapa"
                },
                longitud: {
                    required: "Debe seleccionar una ubicación en el mapa"
                }
            },
            submitHandler: function (form) {
                // Validación adicional: latitud/longitud deben ser números válidos
                const lat = parseFloat($("#latitud").val());
                const lng = parseFloat($("#longitud").val());
                const radio = parseFloat($("#radio").val());

                if (isNaN(lat) || isNaN(lng)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ubicación inválida',
                        text: 'La latitud o longitud no son válidas.'
                    });
                    return false;
                }

                if (isNaN(radio) || radio <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Radio inválido',
                        text: 'Debe ingresar un radio mayor a 0.'
                    });
                    return false;
                }

                form.submit(); 
            }
        });
    });
</script>

@endsection
