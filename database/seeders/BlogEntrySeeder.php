<?php

namespace Database\Seeders;

use App\Models\BlogEntry;
use Illuminate\Database\Seeder;

class BlogEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogEntry::factory()->count(5)->create();
    }
}
