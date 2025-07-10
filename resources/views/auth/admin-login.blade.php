<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
    <h2>Login Administrador</h2>

    @if($errors->any())
        <div style="color:red;">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.login.post') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Correo" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
