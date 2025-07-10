@extends('layout.app')

@section('contenido')

<h1>Bienvenido Usuario</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>

@endsection
