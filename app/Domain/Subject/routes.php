<?php

use App\Http\Controllers\Api\V1\SubjectController;
use Illuminate\Support\Facades\Route;

// Routes for Subject domain
Route::apiResource('/v1/subject', SubjectController::class);
