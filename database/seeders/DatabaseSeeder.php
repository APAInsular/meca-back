<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();
        // Seed other tables

        // // Password reset tokens
        // \App\Models\PasswordResetToken::factory(10)->create();

        // // Failed jobs
        // \App\Models\FailedJob::factory(10)->create();

        // // Personal access tokens
        // \App\Models\PersonalAccessToken::factory(10)->create();

        // // Roles
        // \App\Models\Role::factory(10)->create();

        // Monuments
        \App\Models\Monument::factory(10)->create();

        // Styles
        \App\Models\Style::factory(10)->create();

        // Comments
        // \App\Models\Comment::factory(10)->create();

        // Addresses
        \App\Models\Address::factory(10)->create();

        // Achievements
        \App\Models\Achievement::factory(10)->create();

        // Sub-achievements
        \App\Models\SubAchievement::factory(10)->create();

        // Events
        \App\Models\Event::factory(10)->create();

        // Routes
        \App\Models\Route::factory(10)->create();

        // Stops
        \App\Models\Stop::factory(10)->create();

        // Sponsors
        \App\Models\Sponsor::factory(10)->create();

        // Images
        \App\Models\Image::factory(10)->create();

        // Ratings
        \App\Models\Rating::factory(10)->create();

        // QR codes
        \App\Models\QR::factory(10)->create();

        // Blog entries
        \App\Models\BlogEntry::factory(10)->create();

        // Saves
        \App\Models\Save::factory(10)->create();

        // Tags
        \App\Models\Tag::factory(10)->create();

        // Likes
        \App\Models\Like::factory(10)->create();

        // Authors
        \App\Models\Author::factory(10)->create();

        // Categories
        \App\Models\Category::factory(10)->create();

        // Permissions
        \App\Models\Permission::factory(10)->create();

        // Pivot tables

        // // Author Monument
        // \App\Models\AuthorMonument::factory(10)->create();

        // // Monument User
        // \App\Models\MonumentUser::factory(10)->create();

        // // Address User
        // \App\Models\AddressUser::factory(10)->create();

        // // Achievement User
        // \App\Models\AchievementUser::factory(10)->create();

        // // Sub-achievement User
        // \App\Models\SubAchievementUser::factory(10)->create();

        // // Event Route
        // \App\Models\EventRoute::factory(10)->create();

        // // Event User
        // \App\Models\EventUser::factory(10)->create();

        // // Monument Route
        // \App\Models\MonumentRoute::factory(10)->create();

        // // Route User
        // \App\Models\RouteUser::factory(10)->create();

        // // Stop User
        // \App\Models\StopUser::factory(10)->create();

        // // Blog entry category
        // \App\Models\BlogEntryCategory::factory(10)->create();

        // // Blog entry tag
        // \App\Models\BlogEntryTag::factory(10)->create();

        // // Blog entry user
        // \App\Models\BlogEntryUser::factory(10)->create();

        // // Permission Role
        // \App\Models\PermissionRole::factory(10)->create();
    }
}
