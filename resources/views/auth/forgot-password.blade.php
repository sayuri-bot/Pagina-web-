<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <input type="email" name="email" placeholder="Tu correo" required>
    <button type="submit">Enviar enlace</button>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
</form>