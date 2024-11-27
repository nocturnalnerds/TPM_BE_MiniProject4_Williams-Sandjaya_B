<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get("/", [NoteController::class, "index"]) ->name("notes.index");
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');

