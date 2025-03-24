<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('/wel', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/create', [PostController::class, 'create'])->name('create');
Route::post('/store', [PostController::class, 'store'])->name('store');
Route::get('/show/{id}', [PostController::class, 'show'])->name('show');
Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit');
Route::put('/update', [PostController::class, 'update'])->name('update');
Route::delete('/delete', [PostController::class, 'destroy'])->name('delete');

Route::post('/ajax/eval',[PostController::class, 'eval'])->name('ajax/eval');
