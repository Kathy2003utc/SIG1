<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login Usuario</title>
</head>
<body>
    <h2>Login de Usuario</h2>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="color:red;">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Correo electrónico" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
</body>
</html>
