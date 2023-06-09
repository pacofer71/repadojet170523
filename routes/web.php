<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Socialite\GithubController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TagController;
use App\Http\Livewire\ShowPosts;
use App\Models\Category;
use App\Models\Post;
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
    $posts=Post::with('category', 'user')
    ->where('estado', 'PUBLICADO')
    ->orderBy('id', 'desc')
    ->paginate(5);

    return view('welcome', compact('posts'));
})->name('inicio');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    //metemos la ruta para ver posts porque la queremos protegida
    Route::get('posts', ShowPosts::class)->name('posts.show');
    
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is_admin'
])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
});

Route::get('contacto', [MailController::class, 'pintarFormulario'])->name('contacto.pintar');
Route::post('contacto', [MailController::class, 'procesarFormulario'])->name('contacto.procesar');

Route::get('/auth/github/redirect', [GithubController::class, 'redirect'])->name('github.redirect');
Route::get('/auth/github/callback', [GithubController::class, 'callback'])->name('github.callback');

