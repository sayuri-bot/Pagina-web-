@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">

                <h4 class="mb-3">¿Olvidaste tu contraseña?</h4>
                <p class="text-muted">Te enviaremos un enlace para restablecerla.</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" required
                               class="form-control @error('email') is-invalid @enderror">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-dark w-100">
                        Enviar enlace
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Volver al login</a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection