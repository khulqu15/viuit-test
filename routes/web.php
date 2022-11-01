<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

    Route::middleware(['admin.role'])->group(function () {
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::patch('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::get('/transaction/edit/{transaction}', [TransactionController::class, 'edit'])->name('transaction.edit');
        Route::patch('/transaction/update/{transaction}', [TransactionController::class, 'update'])->name('transaction.update');
        Route::delete('/transaction/destroy/{transaction}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });
});
