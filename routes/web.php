<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartsController;

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
Auth::routes();


// Route::middleware('auth')->group(function () {
Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{user}', [UserController::class,'index'])->name('user.show');


Route::get('/store', [StoresController::class,'index']);
Route::get('/store/{store}', [StoresController::class,'show'])->name('store.show');
Route::post('/store', [StoresController::class,'store']);
Route::patch('/store/{store}', [StoresController::class,'update'])->name('store.update');


Route::get('/product', [ProductsController::class,'index']);
Route::get('/product/{product}', [ProductsController::class,'show'])->name('product.show');
Route::post('/product', [ProductsController::class,'store']);
Route::patch('/product/{product}', [ProductsController::class,'update'])->name('product.update');

Route::get('/cart', [CartsController::class,'index']);
Route::get('/cart/{cart}', [CartsController::class,'show'])->name('cart.show');
Route::post('/cart', [CartsController::class,'store']);
// Route::patch('/cart/{cart}', [CartsController::class,'update'])->name('cart.update');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });