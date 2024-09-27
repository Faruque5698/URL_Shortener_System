<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;

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
    return redirect('/login');
});
Route::post('/generate-url',[ShortUrlController::class,'store'])->name('generate.url');
Route::get('shorturl/{short_url}', [ShortUrlController::class, 'redirectShortUrl'])->name('redirect.url');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
