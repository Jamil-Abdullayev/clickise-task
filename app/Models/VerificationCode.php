<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = ['code', 'user_id', 'setting_id', 'verification_method', 'expires_at'];

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
