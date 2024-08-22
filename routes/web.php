<?php

use App\Services\Quotes\QuotesManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    app(QuotesManager::class)
        ->driver('kayne')
        ->test(
            'here'
        );
    return view('welcome');
});
