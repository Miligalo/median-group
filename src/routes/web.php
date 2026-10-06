<?php

use App\Http\Controllers\LandingController;
use App\Http\Middleware\CaptureUtmParams;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])
    ->middleware(CaptureUtmParams::class);
