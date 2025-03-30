<?php

use App\Http\Controllers\NodeController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/tree', [NodeController::class, 'tree']);
    Route::get('/flat', [NodeController::class, 'flat']);
    Route::post('/nodes', [NodeController::class, 'store']);
    Route::delete('/nodes/{node}', [NodeController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
