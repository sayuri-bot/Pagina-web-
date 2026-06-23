<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
</head>

<body style="background:#f4f4f4; font-family:Arial;">

<div style="max-width:600px;margin:auto;background:#fff;border-radius:10px;overflow:hidden;">

    <!-- HEADER -->
    <div style="background:#f2dd6c;padding:20px;text-align:center;">
        <h2 style="margin:0;color:#3e350e;">☕ PROCAFES</h2>
    </div>

    <!-- BODY -->
    <div style="padding:20px;">

        <h3>Hola {{ $user->name }} 👋</h3>

        <p>Dejaste estos productos en tu carrito:</p>

        @foreach($items as $item)
            <div style="display:flex;align-items:center;margin-bottom:15px;border-bottom:1px solid #eee;padding-bottom:10px;">
                
                <img src="{{ $item->product->image ?? '' }}"
                     style="width:70px;height:70px;object-fit:cover;border-radius:6px;margin-right:10px;">

                <div>
                    <strong>{{ $item->product->name ?? 'Producto' }}</strong><br>
                    Cantidad: {{ $item->quantity }}<br>
                    Precio: S/ {{ $item->price }}
                </div>

            </div>
        @endforeach

        <!-- BOTÓN -->
        <div style="text-align:center;margin:25px 0;">
            <a href="{{ $url }}"
               style="background:#3e350e;color:#fff;padding:12px 25px;text-decoration:none;border-radius:6px;">
               Recuperar mi carrito
            </a>
        </div>

        <p style="color:#777;">¡No dejes que se acaben!</p>

    </div>

</div>

</body>
</html>