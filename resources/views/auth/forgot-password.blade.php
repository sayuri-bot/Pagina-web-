@extends('layouts.app')

@section('content')

<h2>PRUEBA TOTAL</h2>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <input type="email" name="email" placeholder="correo" required>
    <button type="submit">Enviar enlace</button>
</form>

@endsection