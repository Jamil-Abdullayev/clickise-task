<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => fake()->word(),
            'value' => fake()->sentence(),
            'requires_verification' => fake()->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
