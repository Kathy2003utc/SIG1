@extends('layout.app')

@section('contenido')

    <h1 class="text-center">Nueva Zona Segura</h1><br>

    <div class="container" style="max-width: 1100px; margin: 0 auto;">
        <form id="frm_zona_segura" action="{{ route('admin.ZonasSeguras.store') }}" method="POST" id="frm_nueva_zona_segura">
            @csrf

            <label for="nombre"><b>Nombre:</b></label>
            <div class="mb-3">
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese el nombre de la zona" value="{{ old('nombre') }}">
                @error('nombre')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <label for="tipo_seguridad"><b>Tipo de Seguridad:</b></label>
            <div class="mb-3">
                <select name="tipo_seguridad" id="tipo_seguridad" class="form-control @error('tipo_seguridad') is-invalid @enderror">
                    <option value="">--Seleccione--</option>
                    <option value="Refugio" {{ old('tipo_seguridad') == 'Refugio' ? 'selected' : '' }}>Refugio</option>
                    <option value="Zona de evacuación" {{ old('tipo_seguridad') == 'Zona de evacuación' ? 'selected' : '' }}>Zona de evacuación</option>
                    <option value="Centro de salud" {{ old('tipo_seguridad') == 'Centro de salud' ? 'selected' : '' }}>Centro de salud</option>
                </select>
                @error('tipo_seguridad')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <label for="radio"><b>Radio (en metros):</b></label>
            <div class="mb-3">
                <input type="number" name="radio" id="radio" class="form-control @error('radio') is-invalid @enderror" placeholder="Ingrese el radio de seguridad" value="{{ old('radio') }}">
                @error('radio')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="latitud"><b>Latitud:</b></label>
                    <div class="mb-3">
                        <input type="text" name="latitud" id="latitud" class="form-control @error('latitud') is-invalid @enderror" readonly value="{{ old('latitud') }}">
                        @error('latitud')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="longitud"><b>Longitud:</b></label>
                    <div class="mb-3">
                        <input type="text" name="longitud" id="longitud" class="form-control @error('longitud') is-invalid @enderror" readonly value="{{ old('longitud') }}">
                        @error('longitud')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <label for=""><b>Ubicación de la Zona Segura:</b></label>
            <div id="mapa1" style="border:2px solid black; height:300px; width:100%;"></div>
            <br>

            <button class="btn btn-success">Guardar</button>
            &nbsp; &nbsp;
            <button type="button" onclick="graficarCirculo()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo">Graficar</button>
            &nbsp; &nbsp;
            <a href="{{ route('admin.ZonasSeguras.index') }}" class="btn btn-danger">Cancelar</a>

        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalGraficoCirculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Rango de Seguridad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="mapa-circulo" style="border:2px solid blue; height:300px; width:100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var mapa;
        function initMap() {
            var latLngInicial = new google.maps.LatLng(-0.9374805, -78.6161327);
            mapa = new google.maps.Map(document.getElementById('mapa1'), {
                center: latLngInicial,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var marcador = new google.maps.Marker({
                position: latLngInicial,
                map: mapa,
                title: "Ubicación de la zona segura",
                draggable: true
            });

            google.maps.event.addListener(marcador, 'dragend', function () {
                var lat = this.getPosition().lat();
                var lng = this.getPosition().lng();
                document.getElementById("latitud").value = lat;
                document.getElementById("longitud").value = lng;
            });
        }

        function graficarCirculo(){
            var radio = document.getElementById('radio').value;
            var latitud = document.getElementById('latitud').value;
            var longitud = document.getElementById('longitud').value;

            var centro = new google.maps.LatLng(latitud, longitud);

            var mapaCirculo = new google.maps.Map(document.getElementById('mapa-circulo'), {
                center: centro,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.SATELLITE
            });

            new google.maps.Marker({
                position: centro,
                map: mapaCirculo,
                title: "Centro de la zona",
                draggable: false
            });

            new google.maps.Circle({
                strokeColor: "red",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "blue",
                fillOpacity: 0.5,
                map: mapaCirculo,
                center: centro,
                radius: parseFloat(radio)
            });
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
