<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPasswordCustom;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No existe ese correo'
            ]);
        }

        // 🔥 generar token
        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );

        // 🔥 enviar correo
        $user->notify(new ResetPasswordCustom($token));

        return back()->with('status', 'Correo enviado ✅');
    }
}