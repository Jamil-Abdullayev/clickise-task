<?php

namespace App\Interfaces;

interface VerificationServiceInterface
{
    public function generateCode();
    public function chanelSelect(string $code , string $type);
    public function verify(string $code, string $verificationId);
}
