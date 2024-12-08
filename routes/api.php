<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthApiController::class,'Register']);
Route::post('/login',[AuthApiController::class,'Login']);

Route::get('/login', function(){
    return response()->json([
        'success' => false,
        'message' => 'Please Login First!',
    ]);
})->name('login');

Route::middleware(['auth:api'])->group(function () {    
    Route::get('/',[NoteController::class,'index']);
    Route::post('/createNote',[NoteController::class,'createNote']);
    Route::put('/updateNote/{id}',[NoteController::class,'updateNote']);
    Route::delete('/deleteNote/{id}',[NoteController::class,'deleteNote']);
});