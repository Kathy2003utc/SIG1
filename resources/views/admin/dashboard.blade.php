@extends('layout.app')

@section('contenido')

<div class="container mt-5">
    <h1 class="text-center mb-4 text-success">Bienvenido, Administrador</h1>

    <div class="card shadow p-4 mb-4 bg-white rounded">
        <h4 class="mb-3">Resumen del Sistema</h4>
        <p>
            Este sistema está diseñado para facilitar la gestión de zonas de riesgo y puntos de encuentro seguros en tu comunidad. 
            Como administrador, tienes acceso completo para supervisar, registrar, editar y eliminar información relacionada 
            con las zonas geográficas, así como gestionar los usuarios que interactúan con la plataforma.
        </p>
        <p>
            Desde este panel puedes verificar reportes, actualizar la base de datos, y garantizar que toda la información 
            publicada esté correctamente validada y disponible para los usuarios autorizados.
        </p>
    </div>
</div>

@endsection
