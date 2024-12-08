<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get('/register',[AuthController::class, 'viewRegister',])->name('register.view');
Route::post('/register',[AuthController::class,'register'])->name('reigster.create');
Route::get('/login',[AuthController::class,'viewLogin'])->name('login.view');
// Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/', [NoteController::class, 'index'])->name('notes.index')->middleware('isLogin');
Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create')->middleware('isLogin');;
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store')->middleware('isLogin');;
Route::get('/notes/{id}/edit', [NoteController::class, 'edit'])->name('notes.edit')->middleware('isLogin');
Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update')->middleware('isLogin');;
Route::delete('/notes/{id}', [NoteController::class, 'delete'])->name('notes.delete')->middleware('isLogin');;