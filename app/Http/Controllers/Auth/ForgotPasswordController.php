<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPasswordCustom;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return back()->with('success', 'Te enviamos un enlace a tu correo para restablecer tu contraseña');
}

}