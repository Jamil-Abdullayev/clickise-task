<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('settings', [SettingController::class, 'index']);
    Route::post('settings/{setting}', [SettingController::class, 'update']);
    Route::post('settings/{setting}/verify', [SettingController::class, 'verify']);
    Route::get('settings/{setting}/getSettingValue', [SettingController::class, 'getSettingValue']);
});
