<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //メモ管理画面
    Route::get('/', [MemoController::class, 'index'])->name('index');
    Route::post('store', [MemoController::class, 'store'])->name('store');
    Route::get('edit/{memo}', [MemoController::class, 'edit'])->name('edit');
    Route::put('update/{memo}', [MemoController::class, 'update'])->name('update');
    Route::put('destroy/{memo}', [MemoController::class, 'destroy'])->name('destroy');

    //タグ管理画面
    Route::get('/tag', [TagController::class, 'index'])->name('tag.index');
    Route::post('/tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::put('/tag/destroy', [TagController::class, 'destroy'])->name('tag.destroy');

    //画像管理画面
    Route::get('/image', [ImageController::class, 'index'])->name('image.index');
    Route::get('/image/create', [ImageController::class, 'create'])->name('image.create');
    Route::post('/image/store', [ImageController::class, 'store'])->name('image.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
