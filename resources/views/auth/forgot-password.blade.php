<h1>TEST</h1>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <input type="email" name="email" value="test@test.com">

    <button type="submit">ENVIAR</button>
</form>