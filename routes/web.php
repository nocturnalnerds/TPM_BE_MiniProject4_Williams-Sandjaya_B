<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get("/", [NoteController::class, "index"]) ->name("notes.index");
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notes/edit', [NoteController::class, 'editView'])->name('notes.editView');
Route::delete('/notes/{note}', [NoteController::class, 'delete'])->name('notes.delete');