<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TrashedMemoController;
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
    Route::controller(MemoController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{memo}', 'edit')->name('edit');
        Route::patch('update/{memo}', 'update')->name('update');
        Route::delete('destroy/{memo}', 'destroy')->name('destroy');
    });

    //ソフトデリートしたメモ画面
    Route::controller(TrashedMemoController::class)->prefix('trashed-memo')->group(function () {
        Route::get('/', 'trashedMemoIndex')->name('trashed-memo.index');
        Route::patch('/undo/{trashed}', 'trashedMemoUndo')->name('trashed-memo.undo');
        Route::delete('/destroy/{trashed}', 'trashedMemoDestroy')->name('trashed-memo.destroy');
    });

    //タグ管理画面
    Route::controller(TagController::class)->prefix('tag')->group(function () {
        Route::get('/', 'index')->name('tag.index');
        Route::post('/store', 'store')->name('tag.store');
        Route::delete('/destroy', 'destroy')->name('tag.destroy');
    });

    //画像管理画面
    Route::controller(ImageController::class)->prefix('image')->group(function () {
        Route::get('/', 'index')->name('image.index');
        Route::get('/create', 'create')->name('image.create');
        Route::post('/store', 'store')->name('image.store');
        Route::get('/edit/{image}', 'edit')->name('image.edit');
        Route::patch('/update/{image}', 'update')->name('image.update');
        Route::delete('/destroy/{image}', 'destroy')->name('image.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
