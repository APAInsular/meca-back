<?php

namespace Database\Seeders;

use App\Models\QR;
use Illuminate\Database\Seeder;

class QRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QR::factory()->count(5)->create();
    }
}
