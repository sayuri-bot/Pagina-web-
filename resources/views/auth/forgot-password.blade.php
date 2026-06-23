@extends('layouts.app')

@section('content')

<h2>PRUEBA TOTAL</h2>

<form method="POST" action="/test-directo">
    @csrf

    <input type="email" name="email" value="test@test.com">
    <button type="submit">ENVIAR</button>
</form>

@endsection