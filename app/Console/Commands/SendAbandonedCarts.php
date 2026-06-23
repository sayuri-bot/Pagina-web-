<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\AbandonedCartNotification;

class SendAbandonedCarts extends Command
{
    protected $signature = 'cart:abandoned';
    protected $description = 'Enviar correos de carritos abandonados';

    public function handle()
    {
        $hours = 6; // 🔥 puedes cambiar a 24 horas

        $users = User::whereHas('cartItems', function ($q) use ($hours) {
            $q->where('updated_at', '<', now()->subHours($hours));
        })->get();

        foreach ($users as $user) {

            // 🔥 verificar última actividad
            $session = DB::table('sessions')
                ->where('user_id', $user->id)
                ->orderByDesc('last_activity')
                ->first();

            if ($session && $session->last_activity > now()->subHours($hours)->timestamp) {
                continue; // usuario activo → NO enviar
            }

            // enviar correo
            $user->notify(new AbandonedCartNotification($user->cartItems));

            $this->info("Correo enviado a: ".$user->email);
        }

        return 0;
    }
}
