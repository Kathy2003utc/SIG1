@extends('layouts.appUser')
@section('content')

<h1>Bienvenido Usuario</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>

@endsection
