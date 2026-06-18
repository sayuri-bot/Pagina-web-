<?php

namespace App\Services;

use Resend\Resend; // 👈 ESTE ES EL QUE FALTABA

class ResendMailService
{
    protected $resend;

    public function __construct()
    {
        $this->resend = new Resend(env('RESEND_KEY'));
    }

    public function sendVerificationCode($email, $code)
    {
        try {
            return $this->resend->emails->send([
                'from' => 'PROCÁFES <onboarding@resend.dev>',
                'to' => $email,
                'subject' => 'Código de verificación',
                'html' => "<h1>Tu código: {$code}</h1>",
            ]);
        } catch (\Exception $e) {
            \Log::error('RESEND ERROR: ' . $e->getMessage());
            dd($e->getMessage());
        }
    }
}