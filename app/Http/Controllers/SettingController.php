<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\VerificationServiceInterface;
use App\Models\Setting;
use App\Models\VerificationCode;


class SettingController extends Controller
{
    protected $verificationService;

    public function __construct(VerificationServiceInterface $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function index(Setting $setting)
    {
        return Setting::all(['id', 'key', 'value', 'requires_verification']);
    }
    public function getSettingValue(Setting $setting)
    {
        return response()->json([
            'message'=>'success',
            'settingValue'=>$setting->value,
            'settingKey'=>$setting->key
        ]);
    }
    public function update(Request $request, Setting $setting)
    {
        if ($setting->requires_verification) {
            $code = $this->verificationService->generateCode();

            $verification = VerificationCode::create([
                'code' => $code,
                'user_id' => 1,
                'setting_id' => $setting->id,
                'verification_method' => $request->verification_method,
                'expires_at' => now()->addMinutes(30),
            ]);


            return response()->json([
                'message' => $this->verificationService->chanelSelect($code, $request->verification_method),
                'verification_id' => $verification->id
            ]);
        }

        $setting->update($request->only('value'));
        return response()->json(['message' => 'Setting updated successfully']);
    }

    public function verify(Request $request, Setting $setting)
    {
        $verified = $this->verificationService->verify(
            $request->code,
            $request->verification_id
        );

        if (!$verified) {
            return response()->json(['message' => 'Invalid code'], 422);
        }

        $setting->update(['value' => $request->value]);
        return response()->json(['message' => 'Setting updated successfully']);
    }
}
