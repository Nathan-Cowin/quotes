<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Facades\Quote;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/quotes', function (Request $request) {
    Quote::driver('kayne')
    ->setCount(5)
    ->getQuotes();

//    return response()->json([
//        'data' => 'ok'
//    ]);
});
Route::get('/quotes/refresh', function (Request $request) {
    Quote::driver('kayne')
    ->clearSaved()
    ->setCount(5)
    ->getQuotes();

//    return response()->json([
//        'data' => 'ok'
//    ]);
});
