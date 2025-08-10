<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ➀商品一覧画面
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ➂商品登録画面表示
Route::get('/products/register', [ProductController::class, 'register'])->name('products.register');

// ➂商品登録処理
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// ➁商品詳細兼更新画面表示
Route::get('/products/{productId}', [ProductController::class, 'edit'])->name('products.edit');

// ➁商品更新処理
Route::patch('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');

// ➁商品削除処理
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
