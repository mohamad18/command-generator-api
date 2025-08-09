<?php

use App\Http\Controllers\Api\V1\SchoolController;
use Illuminate\Support\Facades\Route;

// Routes for School domain
Route::apiResource('/v1/school', SchoolController::class);
