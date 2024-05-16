<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonumentUser>
 */
use App\Models\Monument;
use App\Models\MonumentUser;
use App\Models\User;

class MonumentUserFactory extends Factory
{
    protected $model = MonumentUser::class;

    public function definition()
    {
        return [
            'monument_id' => Monument::factory(),
            'user_id' => User::factory(),
        ];
    }
}
