<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\CartController;

Route::get('/register',[AuthController::class, 'viewRegister',])->name('register.view');
Route::post('/register',[AuthController::class,'register'])->name('reigster.create');
Route::get('/login',[AuthController::class,'viewLogin'])->name('login.view');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/', [StorageController::class, 'index'])->name('storage.index')->middleware('isLogin');
Route::get('/storage', [StorageController::class, 'index']);
Route::get('/storage/create', [StorageController::class, 'create'])->name('storage.create')->middleware('isLogin');
Route::post('/storage/store', [StorageController::class, 'store'])->name('storage.store')->middleware('isLogin');
Route::get('/storage/{id}/edit', [StorageController::class, 'edit'])->name('storage.edit')->middleware('isLogin');
Route::put('/storage/{id}', [StorageController::class, 'update'])->name('storage.update')->middleware('isLogin');
Route::delete('/storage/{id}', [StorageController::class, 'delete'])->name('storage.delete')->middleware('isLogin');


Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');


Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
