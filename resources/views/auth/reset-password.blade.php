<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Restablecer contraseña</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<!-- CONTENEDOR -->
<table width="600" style="background:#ffffff; margin:40px auto; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

<!-- HEADER -->
<tr>
<td style="background:#f2dd6c; padding:20px; text-align:center;">
    <h1 style="margin:0; color:#3e350e;">☕ PROCAFES</h1>
</td>
</tr>

<!-- BODY -->
<tr>
<td style="padding:30px; color:#333;">

    <h2 style="margin-top:0;">Hola 👋</h2>

    <p>
        Recibimos una solicitud para restablecer tu contraseña.
    </p>

    <p>
        Haz clic en el siguiente botón para continuar:
    </p>

    <!-- BOTÓN -->
    <div style="text-align:center; margin:30px 0;">
        <a href="{{ $url }}"
           style="
           background:#3e350e;
           color:#ffffff;
           padding:14px 28px;
           text-decoration:none;
           border-radius:6px;
           font-weight:bold;
           display:inline-block;">
           Restablecer contraseña
        </a>
    </div>

    <p style="color:#666;">
        Este enlace expirará en 60 minutos.
    </p>

    <p style="color:#666;">
        Si no solicitaste este cambio, puedes ignorar este mensaje.
    </p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td style="background:#f9f9f9; padding:20px; text-align:center; font-size:12px; color:#999;">
    © {{ date('Y') }} PROCAFES — Todos los derechos reservados
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>