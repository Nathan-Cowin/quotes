<?php

use App\Http\Controllers\ViewController;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/quotes', [ViewController::class, 'index']);
Route::post('/quotes/refresh', [ViewController::class, 'refresh']);
