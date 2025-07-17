<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión - Login Administrador</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to right, #2c2c2c, #444);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .title {
            color: white;
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
            padding: 0 20px;
        }

        .login-container {
            background-color: #fff;
            padding: 60px 50px;
            border-radius: 16px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.3);
            width: 400px;
            max-width: 90%;
            text-align: center;
        }

        h2 {
            color: #2c2c2c;
            margin-bottom: 20px;
            font-size: 24px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #f57c00; /* Naranja */
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e65100;
        }

        .alert-error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1 class="title">Sistema de Gestión de Zonas de Seguridad y Puntos de Encuentro Comunitarios</h1>

    <div class="login-container">
        <h2>Login Administrador</h2>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>

</body>
</html>
