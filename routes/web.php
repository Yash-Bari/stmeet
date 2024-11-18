<?php

use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ProfileController::class, 'showForm'])->name('home');
Route::post('/start', [ProfileController::class, 'setPreferences'])->name('start');
Route::get('/chat/{session_id}', [VideoCallController::class, 'chat'])->name('chat');
Route::post('/session/create', [VideoCallController::class, 'createSession']);
Route::post('/session/find-match', [VideoCallController::class, 'findMatch']);
Route::post('/session/end', [VideoCallController::class, 'endSession']);
