<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Front\Home;
use App\Http\Livewire\Back\Dashboard;
use App\Http\Livewire\Back\Usermanage;
use App\Http\Livewire\Back\Catmanage;
use App\Http\Livewire\Back\Othercat;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', Home::class)->name('home');

/* Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard',Dashboard::class)->name('dashboard');
    Route::get('/mycatman', Catmanage::class)->name('mycatman');
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/userman', Usermanage::class)->name('userman');
        Route::get('/othercat', Othercat::class)->name('othercat');
    });
});