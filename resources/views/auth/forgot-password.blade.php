<h2>TEST FORM</h2>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <input type="email" name="email" value="test@test.com" required>

    <button type="submit">ENVIAR</button>
</form>