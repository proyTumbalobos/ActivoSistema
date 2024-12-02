<!DOCTYPE html>
<html lang="es">

<head>
    <title>EMPRESA - Inicio de Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="main-frame">
        <div class="login-box">
            <div class="icon-wrapper">
                <img src="{{ asset('img/logoTexto.png') }}" alt="Empresa" class="profile-img">
            </div>
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <span class="input-icon"><i class="bi bi-person-fill-lock"></i></span>
                    <input name="dni" type="text" class="form-control" placeholder="Usuario">
                </div>
                <div class="input-group">
                    <span class="input-icon"><i class="bi bi-key-fill"></i></span>
                    <input type="password" name="contraseña" class="form-control" placeholder="Contraseña">
                </div>
                <button type="submit" class="btn btn-info">INGRESAR</button>
            </form>
        </div>
    </div>
</body>

</html>
