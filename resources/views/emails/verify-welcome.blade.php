<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verificar correo</title>
</head>
<body>
    <h2>Hola {{ $user->name }}</h2>

    <p>Gracias por registrarte en Pro Cafes ☕</p>

    <p>Por favor verifica tu correo haciendo clic en el siguiente botón:</p>

    <a href="{{ $url }}" style="
        display:inline-block;
        padding:10px 20px;
        background-color:#6b4f4f;
        color:#fff;
        text-decoration:none;
        border-radius:5px;
    ">
        Verificar correo
    </a>

    <p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>
</body>
</html>