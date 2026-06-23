@extends('layouts.app')

@section('content')

<div class="row justify-content-center" style="min-height:70vh;align-items:center;">
    <div class="col-md-5">

        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-4">

                <h4 class="mb-3">Restablecer contraseña</h4>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ request('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Nueva contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-procafes-dark w-100">
                        Guardar nueva contraseña
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection