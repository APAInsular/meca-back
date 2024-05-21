<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\RolUserController;

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




Route::post('/assign-role', [RolUserController::class, 'assignRole']);
Route::post('/remove-role', [RolUserController::class, 'removeRole']);
