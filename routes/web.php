<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoresController;

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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });