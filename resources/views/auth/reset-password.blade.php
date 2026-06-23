@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="card shadow-lg border-0 rounded-4" style="max-width:500px; width:100%;">
        
        <div class="card-header text-center bg-procafes">
            <h4 class="mb-0 text-dark fw-bold">☕ Restablecer contraseña</h4>
        </div>

        <div class="card-body p-4">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- TOKEN -->
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ request()->email }}" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <!-- CONFIRM -->
                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-procafes-dark">
                        Guardar nueva contraseña
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection