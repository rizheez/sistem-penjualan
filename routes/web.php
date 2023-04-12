<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\TransaksiDetailController;

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

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login.form');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/create', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.delete');

    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier/create', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');

    Route::get('/produk-masuk', [ProdukMasukController::class, 'index'])->name('produk-masuk.index');
    Route::get('/produk-masuk/create', [ProdukMasukController::class, 'create'])->name('produk-masuk.create');
    Route::post('/produk-masuk/create', [ProdukMasukController::class, 'store'])->name('produk-masuk.store');
    Route::get('/produk-masuk/{id}/edit', [ProdukMasukController::class, 'edit'])->name('produk-masuk.edit');
    Route::put('/produk-masuk/{id}', [ProdukMasukController::class, 'update'])->name('produk-masuk.update');
    Route::delete('/produk-masuk/{id}', [ProdukMasukController::class, 'destroy'])->name('produk-masuk.delete');

    Route::get('/transaksi', [TransaksiDetailController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiDetailController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/create', [TransaksiDetailController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}/edit', [TransaksiDetailController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [TransaksiDetailController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [TransaksiDetailController::class, 'destroy'])->name('transaksi.delete');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::get('/', function () {
    return redirect()->to('dashboard');
});
