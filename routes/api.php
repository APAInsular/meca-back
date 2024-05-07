<?php

use App\Http\Controllers\Api\MonumentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('/user', UserController::class);

<<<<<<< HEAD
Route::get('top-rated-monuments', [MonumentController::class, 'getTopRatedMonuments']);

Route::get('users/points-category', [UserController::class, 'getUsersByPointsCategory']);
//"SQLSTATE[HY000]: General error: 1364 Field 'name' doesn't have a default value (Connection: mysql, SQL: insert into `users` (`email`, `password`, `updated_at`, `created_at`) values (luiscliente1@luis.com, $2y$12$IPXD0FXSNzXeOHWTfsrszeRZgviwldlh4H.XlwYW8YZkr.2mny4mC, 2024-05-07 08:41:29, 2024-05-07 08:41:29))"

///////////////////////////////////////////////////////

=======
>>>>>>> f49a8085e82e03201687e6926fb3d8a5e841a6bd
Route::get('q-rs/error', [App\Http\Controllers\Api\QRController::class, 'error']);
Route::resource('q-rs', App\Http\Controllers\Api\QRController::class)->except('create', 'edit');

Route::get('monuments/error', [App\Http\Controllers\Api\MonumentController::class, 'error']);
Route::resource('monuments', App\Http\Controllers\Api\MonumentController::class)->except('create', 'edit');

Route::get('blog-entries/error', [App\Http\Controllers\Api\BlogEntryController::class, 'error']);
Route::resource('blog-entries', App\Http\Controllers\Api\BlogEntryController::class)->except('create', 'edit');

Route::get('styles/error', [App\Http\Controllers\Api\StyleController::class, 'error']);
Route::resource('styles', App\Http\Controllers\Api\StyleController::class)->except('create', 'edit');

Route::get('comments/error', [App\Http\Controllers\Api\CommentController::class, 'error']);
Route::resource('comments', App\Http\Controllers\Api\CommentController::class)->except('create', 'edit');

Route::get('addresses/error', [App\Http\Controllers\Api\AddressController::class, 'error']);
Route::resource('addresses', App\Http\Controllers\Api\AddressController::class)->except('create', 'edit');

Route::get('achievements/error', [App\Http\Controllers\Api\AchievementController::class, 'error']);
Route::resource('achievements', App\Http\Controllers\Api\AchievementController::class)->except('create', 'edit');

Route::get('sub-achievements/error', [App\Http\Controllers\Api\SubAchievementController::class, 'error']);
Route::resource('sub-achievements', App\Http\Controllers\Api\SubAchievementController::class)->except('create', 'edit');

Route::get('events/error', [App\Http\Controllers\Api\EventController::class, 'error']);
Route::resource('events', App\Http\Controllers\Api\EventController::class)->except('create', 'edit');

Route::get('routes/error', [App\Http\Controllers\Api\RouteController::class, 'error']);
Route::resource('routes', App\Http\Controllers\Api\RouteController::class)->except('create', 'edit');

Route::get('stops/error', [App\Http\Controllers\Api\StopController::class, 'error']);
Route::resource('stops', App\Http\Controllers\Api\StopController::class)->except('create', 'edit');

Route::get('sponsors/error', [App\Http\Controllers\Api\SponsorController::class, 'error']);
Route::resource('sponsors', App\Http\Controllers\Api\SponsorController::class)->except('create', 'edit');

Route::get('images/error', [App\Http\Controllers\Api\ImageController::class, 'error']);
Route::resource('images', App\Http\Controllers\Api\ImageController::class)->except('create', 'edit');

Route::get('ratings/error', [App\Http\Controllers\Api\RatingController::class, 'error']);
Route::resource('ratings', App\Http\Controllers\Api\RatingController::class)->except('create', 'edit');

Route::get('authors/error', [App\Http\Controllers\Api\AuthorController::class, 'error']);
Route::resource('authors', App\Http\Controllers\Api\AuthorController::class)->except('create', 'edit');
<<<<<<< HEAD
=======

// ----------------------------  CUSTOMIZE QUERYS  ----------------------------

Route::get('monuments/all-info', [App\Http\Controllers\Api\MonumentController::class, 'allMonumentInfo']);
>>>>>>> f49a8085e82e03201687e6926fb3d8a5e841a6bd
