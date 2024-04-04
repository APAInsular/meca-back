<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('obras/error', [App\Http\Controllers\Api\ObraController::class, 'error']);
Route::resource('obras', App\Http\Controllers\Api\ObraController::class)->except('create', 'edit');

Route::get('entrada-blogs/error', [App\Http\Controllers\Api\EntradaBlogController::class, 'error']);
Route::resource('entrada-blogs', App\Http\Controllers\Api\EntradaBlogController::class)->except('create', 'edit');

Route::get('estilos/error', [App\Http\Controllers\Api\EstiloController::class, 'error']);
Route::resource('estilos', App\Http\Controllers\Api\EstiloController::class)->except('create', 'edit');

Route::get('comentarios/error', [App\Http\Controllers\Api\ComentarioController::class, 'error']);
Route::resource('comentarios', App\Http\Controllers\Api\ComentarioController::class)->except('create', 'edit');

Route::get('direccions/error', [App\Http\Controllers\Api\DireccionController::class, 'error']);
Route::resource('direccions', App\Http\Controllers\Api\DireccionController::class)->except('create', 'edit');

Route::get('logros/error', [App\Http\Controllers\Api\LogroController::class, 'error']);
Route::resource('logros', App\Http\Controllers\Api\LogroController::class)->except('create', 'edit');

Route::get('sub-logros/error', [App\Http\Controllers\Api\SubLogroController::class, 'error']);
Route::resource('sub-logros', App\Http\Controllers\Api\SubLogroController::class)->except('create', 'edit');

Route::get('eventos/error', [App\Http\Controllers\Api\EventoController::class, 'error']);
Route::resource('eventos', App\Http\Controllers\Api\EventoController::class)->except('create', 'edit');

Route::get('rutas/error', [App\Http\Controllers\Api\RutaController::class, 'error']);
Route::resource('rutas', App\Http\Controllers\Api\RutaController::class)->except('create', 'edit');

Route::get('paradas/error', [App\Http\Controllers\Api\ParadaController::class, 'error']);
Route::resource('paradas', App\Http\Controllers\Api\ParadaController::class)->except('create', 'edit');

Route::get('patrocinadors/error', [App\Http\Controllers\Api\PatrocinadorController::class, 'error']);
Route::resource('patrocinadors', App\Http\Controllers\Api\PatrocinadorController::class)->except('create', 'edit');

Route::get('imagens/error', [App\Http\Controllers\Api\ImagenController::class, 'error']);
Route::resource('imagens', App\Http\Controllers\Api\ImagenController::class)->except('create', 'edit');

Route::get('calificacions/error', [App\Http\Controllers\Api\CalificacionController::class, 'error']);
Route::resource('calificacions', App\Http\Controllers\Api\CalificacionController::class)->except('create', 'edit');

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

Route::get('q-rs/error', [App\Http\Controllers\Api\QRController::class, 'error']);
Route::resource('q-rs', App\Http\Controllers\Api\QRController::class)->except('create', 'edit');
