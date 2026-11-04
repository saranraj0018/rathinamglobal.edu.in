<?php

use App\Http\Controllers\Assistant\GeminiLiveTokenController;
use Illuminate\Support\Facades\Route;

// THIS IS NEW CODE — expose the throttled one-use token endpoint. Reason: browsers must not receive the permanent key.
Route::post('/gemini-live/token', GeminiLiveTokenController::class)
    ->middleware('throttle:assistant')
    ->name('gemini-live.token');
