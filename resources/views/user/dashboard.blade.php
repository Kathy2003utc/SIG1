@extends('layout.appUser')
@section('contenido')

<div class="container mt-5">
    <h1 class="text-center mb-4">Bienvenido, Usuario</h1>

    <div class="text-center mb-4">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
        </form>
    </div>

    <div class="row justify-content-center">
        <!-- Zonas Seguras -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Zonas Seguras</h5>
                    <p class="card-text">Consulta todas las zonas seguras disponibles en el mapa.</p>
                    <a href="{{ url('/user/usuarioSeguros') }}" class="btn btn-success">Ver Zonas Seguras</a>
                </div>
            </div>
        </div>

        <!-- Puntos de Encuentro -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Puntos de Encuentro</h5>
                    <p class="card-text">Revisa los puntos de encuentro registrados.</p>
                    <a href="{{ url('/user/usuarioPuntos') }}" class="btn btn-primary">Ver Puntos</a>
                </div>
            </div>
        </div>

        <!-- Zonas de Riesgo -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Zonas de Riesgo</h5>
                    <p class="card-text">Observa las zonas de riesgo en el mapa y toma precauciones.</p>
                    <a href="{{ url('/user/usuarioRiesgos') }}" class="btn btn-danger">Ver Zonas de Riesgo</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
