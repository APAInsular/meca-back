<?php

namespace Database\Seeders;

use App\Models\SubAchievement;
use Illuminate\Database\Seeder;

class SubAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubAchievement::factory()->count(5)->create();
    }
}
