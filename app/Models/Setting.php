<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['key', 'value', 'requires_verification', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verificationCodes()
    {
        return $this->hasMany(VerificationCode::class);
    }
}