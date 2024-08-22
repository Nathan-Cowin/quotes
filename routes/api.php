<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Facades\Quote;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//todo refactor to group
Route::get('/{name}/quotes/{count?}', [QuoteController::class, 'getQuotesWithoutRefresh']);
Route::get('/{name}/quotes/{count?}/refresh', [QuoteController::class, 'getRefreshedQuotes']);

Route::get('/quotes/refresh', function (Request $request) {
    Quote::driver('kayne')
    ->clearSaved()
    ->setCount(5)
    ->getQuotes();

//    return response()->json([
//        'data' => 'ok'
//    ]);
});
