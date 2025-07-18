@extends('layout.app')

@section('contenido')
<div class="container">
    <h1 class="mb-4">Editar Punto de Encuentro</h1>

    <form method="POST" action="{{ route('admin.puntos.update', $punto->id) }}" id="frm_punto_encuentro">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required value="{{ old('nombre', $punto->nombre) }}">
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" id="capacidad" name="capacidad" class="form-control" min="1" required value="{{ old('capacidad', $punto->capacidad) }}">
        </div>

        <div class="mb-3">
            <label for="responsable" class="form-label">Responsable</label>
            <input type="text" id="responsable" name="responsable" class="form-control" required value="{{ old('responsable', $punto->responsable) }}">
        </div>

        <div class="mb-3">
            <label for="latitud" class="form-label">Latitud</label>
            <input type="text" id="latitud" name="latitud" class="form-control" readonly required value="{{ old('latitud', $punto->latitud) }}">
        </div>

        <div class="mb-3">
            <label for="longitud" class="form-label">Longitud</label>
            <input type="text" id="longitud" name="longitud" class="form-control" readonly required value="{{ old('longitud', $punto->longitud) }}">
        </div>

        <div id="mapa" style="height: 400px; border: 1px solid #ccc;" class="mb-3"></div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.puntos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    let mapa;
    let marcador;

    function initMap() {
        const initialPos = {
            lat: parseFloat(document.getElementById('latitud').value) || -0.9374805,
            lng: parseFloat(document.getElementById('longitud').value) || -78.6161327
        };

        mapa = new google.maps.Map(document.getElementById('mapa'), {
            zoom: 15,
            center: initialPos
        });

        marcador = new google.maps.Marker({
            position: initialPos,
            map: mapa,
            draggable: true
        });

        marcador.addListener('dragend', function() {
            const pos = marcador.getPosition();
            document.getElementById('latitud').value = pos.lat().toFixed(7);
            document.getElementById('longitud').value = pos.lng().toFixed(7);
        });
    }
</script>

<script>
    $(document).ready(function () {
        $("#frm_punto_encuentro").validate({
            rules: {
                nombre: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                capacidad: {
                    required: true,
                    number: true,
                    min: 1,
                    max: 10000
                },
                responsable: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
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
                    maxlength: "Nombre demasiado largo (máx. 50 caracteres)"
                },
                capacidad: {
                    required: "La capacidad es obligatoria",
                    number: "Debe ingresar un número válido",
                    min: "La capacidad mínima es 1",
                    max: "Capacidad excesiva (máx. 10000 personas)"
                },
                responsable: {
                    required: "El nombre del responsable es obligatorio",
                    minlength: "Debe tener al menos 3 caracteres",
                    maxlength: "Nombre demasiado largo (máx. 50 caracteres)"
                },
                latitud: {
                    required: "Debe seleccionar una ubicación en el mapa"
                },
                longitud: {
                    required: "Debe seleccionar una ubicación en el mapa"
                }
            }
        });
    });
</script>



@endsection
