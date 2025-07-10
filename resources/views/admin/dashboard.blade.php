@extends('layout.app')

@section('contenido')

<h1>Bienvenido Administrador</h1>
<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>

@endsection