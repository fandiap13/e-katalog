<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('home');
});

Route::prefix('auth')->as('auth.')->middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login-process', [AuthController::class, 'process_login']);
});

Route::get('logout', [AuthController::class, 'logout']);

Route::prefix('admin')->as('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('users', UsersController::class)->except(['show']);

    Route::resource('brand', BrandController::class)->except(['show']);

    Route::get("/kategori/showsubkategori/{id}", [KategoriController::class, "showsubkategori"]);
    Route::resource('kategori', KategoriController::class);

    Route::post("/produk/uploadgambar", [ProdukController::class, "uploadgambar"]);
    Route::resource('produk', ProdukController::class)->except(['show']);
});
