<?php

namespace App\Services\Notifications;
use App\Interfaces\NotificationServiceInterface;
use Illuminate\Support\Facades\Log;

class SmsService implements NotificationServiceInterface
{
    public function send(string $code)
    {
        $message = "Verification process: verification code: {$code}, type: SMS";
        Log::info($message);

        return [
            'status' => 'success',
            'message' => $message,
        ];
    }

}
