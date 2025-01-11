<?php

namespace App\Services;
use App\Interfaces\VerificationServiceInterface;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Log;
use App\Services\Notifications;

class VerificationService implements VerificationServiceInterface
{
    protected $channels = [];

    public function __construct(array $channels)
    {
        $this->channels = $channels;
    }

    public function generateCode()
    {
        return (string) random_int(100000, 999999);
    }

    public function chanelSelect( string $code, string $type)
    {
       if($type == 'email')
       {
           $sender = new Notifications\EmailService();
       }
       elseif($type == 'telegram')
       {
           $sender = new Notifications\TelegramService();
       }
       elseif($type == 'sms')
       {
           $sender = new Notifications\SmsService();
       }
       else
       {
           return false;
       }

        return $sender->send($code);

    }

    public function verify(string $code, string $verificationId)
    {
        $verification = VerificationCode::find($verificationId);

        if (!$verification || $verification->expires_at < now()) {
            return false;
        }

        if ($verification->code !== $code) {
            return false;
        }

        $verification->verified_at = now();
        $verification->save();

        return true;
    }
}
