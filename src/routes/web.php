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
    Route::patch('update/{memo}', [MemoController::class, 'update'])->name('update');
    Route::delete('destroy/{memo}', [MemoController::class, 'destroy'])->name('destroy');

    //ソフトデリートしたメモ画面
    Route::prefix('trashed-memo')->group(function () {
        Route::get('/', [MemoController::class, 'trashedMemoIndex'])
            ->name('trashed-memo.index');
        Route::delete('/destroy/{trashed}', [MemoController::class, 'trashedMemoDestroy'])
            ->name('trashed-memo.destroy');
    });

    //タグ管理画面
    Route::prefix('tag')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('tag.index');
        Route::post('/store', [TagController::class, 'store'])->name('tag.store');
        Route::delete('/destroy', [TagController::class, 'destroy'])->name('tag.destroy');
    });

    //画像管理画面
    Route::prefix('image')->group(function () {
        Route::get('/', [ImageController::class, 'index'])->name('image.index');
        Route::get('/create', [ImageController::class, 'create'])->name('image.create');
        Route::post('/store', [ImageController::class, 'store'])->name('image.store');
        Route::get('/edit/{image}', [ImageController::class, 'edit'])->name('image.edit');
        Route::patch('/update/{image}', [ImageController::class, 'update'])->name('image.update');
        Route::delete('/destroy/{image}', [ImageController::class, 'destroy'])->name('image.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
