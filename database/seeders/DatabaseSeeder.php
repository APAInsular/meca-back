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

        // User
        // \App\Models\User::factory(10)->create();

        // Monuments
        // \App\Models\Monument::factory(10)->create();

        // // Monument User
        // \App\Models\MonumentUser::factory(10)->create();


        //Addresses
        \App\Models\Address::factory(10)->create();

        // Address User
        // \App\Models\AddressUser::factory(10)->create();

        //Styles
        \App\Models\Style::factory(10)->create();

        //Images
        \App\Models\Image::factory(10)->create();

        //QR codes
        \App\Models\QR::factory(10)->create();

        //Authors
        \App\Models\Author::factory(10)->create();

        // // Author Monument
        // \App\Models\AuthorMonument::factory(10)->create();













        // // Saves
        // //\App\Models\Save::factory(10)->create();

        // // Ratings
        // //\App\Models\Rating::factory(10)->create();


        // // Routes
        // \App\Models\Route::factory(10)->create();

        // // Route User
        // \App\Models\RouteUser::factory(10)->create();


        // // Stops
        // ///\App\Models\Stop::factory(10)->create();

        // // Stop User
        // \App\Models\StopUser::factory(10)->create();


        // // Sponsors
        // \App\Models\Sponsor::factory(10)->create();


        // // Comments
        // // \App\Models\Comment::factory(10)->create();


        // // Roles
        // \App\Models\Role::factory(10)->create();

    }
}
