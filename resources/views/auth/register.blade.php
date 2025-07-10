<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nombre completo" required><br><br>
        <input type="email" name="email" placeholder="Correo electrónico" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required><br><br>
        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</body>
</html>
