@extends('layouts.app')

@section('content')

<div class="row justify-content-center align-items-center" style="min-height: 70vh;">

    <div class="col-md-6 col-lg-5">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-4 p-lg-5">

                <h3 class="mb-2 fw-bold">¿Olvidaste tu contraseña?</h3>
                <p class="text-muted mb-4">
                    Ingresa tu correo y te enviaremos un enlace para restablecerla.
                </p>

                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" 
                               name="email" 
                               class="form-control"
                               placeholder="tucorreo@ejemplo.com"
                               required>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-procafes-dark btn-lg">
                            Enviar enlace
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="link-procafes text-decoration-none">
                        ← Volver a iniciar sesión
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection