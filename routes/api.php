<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\MonumentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AvatarController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\SubAchievementController;

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

// ----------------------------  CUSTOMIZE QUERYS  ----------------------------

Route::get('monuments/all-info', [MonumentController::class, 'allMonumentInfo']);
Route::get('monuments/{id}', [MonumentController::class, 'findMonumentById']);

Route::resource('/user', UserController::class);

Route::get('top-rated-monuments', [MonumentController::class, 'getTopRatedMonuments']);
Route::get('top-rated-authors', [AuthorController::class, 'getTopRatedAuthors']);

Route::get('users/points-category', [UserController::class, 'getUsersByPointsCategory']);

Route::get('/user/{userId}/points', [UserController::class, 'getUserPoints']);
Route::post('/user/{userId}/up-points', [UserController::class, 'updateUserPoints']);

Route::get('/comments/{commentId}/likes', [LikeController::class, 'likesByComment']);

Route::get('/comments/{commentId}/user-like/{userId}', [LikeController::class, 'getUserLikeForComment']);

Route::get('/check-qr/{userId}/{monumentId}', [MonumentController::class, 'checkQrAndUpdatePoints']);

Route::get('/user/{userId}/profile', [UserController::class, 'getUserProfile']);

Route::get('/subachievement/get-all/{userId}', [SubAchievementController::class, 'getSubachievementsByKeywords']);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('q-rs/error', [App\Http\Controllers\Api\QRController::class, 'error']);
Route::resource('q-rs', App\Http\Controllers\Api\QRController::class)->except('create', 'edit');

Route::get('monuments/error', [App\Http\Controllers\Api\MonumentController::class, 'error']);
Route::resource('monuments', App\Http\Controllers\Api\MonumentController::class)->except('create', 'edit');

Route::get('likes/error', [App\Http\Controllers\Api\LikeController::class, 'error']);
Route::resource('likes', App\Http\Controllers\Api\LikeController::class)->except('create', 'edit');

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

// ----------------------------  CUSTOMIZE QUERYS  ----------------------------

Route::get('monuments/all-info', [App\Http\Controllers\Api\MonumentController::class, 'allMonumentInfo']);
Route::get('monuments/{monumentId}', [MonumentController::class, 'findMonumentById']);

Route::get('authors/mon/{authorId}', [AuthorController::class, 'getMonumentsByAuthor']);

// Ruta para obtener el usuario al que pertenece un avatar
Route::get('/avatar/{id}/user', [AvatarController::class, 'getUserForAvatar']);

// Ruta para obtener toda la información del avatar con sus relaciones
Route::get('/avatar/{id}/details', [AvatarController::class, 'getAvatarWithRelations']);

//Monumentos filtrados por la localidad
Route::get('/monuments/filter-by-locality', [MonumentController::class, 'filterByLocality']);

// Definir la ruta para obtener toda la información de una ruta por ID
Route::get('/routes/{id}/all-info', [RouteController::class, 'allInfoRoute']);

// Ruta para obtener todas las paradas de una misma ruta con paginación
Route::get('/routes/{routeId}/stops', [RouteController::class, 'stopsByRoute']);

// Ruta para obtener todas las rutas agrupadas por estado con paginación
Route::get('/routes/grouped-by-status', [RouteController::class, 'routesGroupedByStatus']);

// Ruta para obtener todas las rutas filtradas por el autor de una obra que se establece como parada, con paginación
Route::get('/routes/by-author/{authorId}', [RouteController::class, 'routesByAuthor']);

// Ruta para obtener todas las rutas filtradas por una obra que se establece como parada, con paginación
Route::get('/routes/by-monument/{monumentId}', [RouteController::class, 'routesByMonument']);

// Ruta para obtener el número total de calificaciones de una ruta y la media de esas calificaciones
Route::get('/routes/{routeId}/ratings', [RouteController::class, 'routeRatings']);

// Ruta para obtener dos rutas destacadas según las mejores calificaciones
Route::get('/routes/highlighted', [RouteController::class, 'highlightedRoutes']);

// Ruta para filtrar rutas por localidad, obra, estilo de obra, autor/res de la obra y calificación de la ruta con paginación
Route::post('/routes/filter', [RouteController::class, 'filterRoutes']);

Route::get('/monuments/filter/{page?}', [MonumentController::class, 'filterMonuments']);
