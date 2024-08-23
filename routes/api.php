<?php

use App\Http\Controllers\QuoteController;
use App\Http\Middleware\AuthenticateWithApiToken;
use Illuminate\Support\Facades\Route;


Route::middleware([AuthenticateWithApiToken::class])->group(function () {
    Route::get('/{name}/quotes/{count?}', [QuoteController::class, 'getQuotesWithoutRefresh']);
    Route::get('/{name}/refresh/{count?}', [QuoteController::class, 'getRefreshedQuotes']);
});
