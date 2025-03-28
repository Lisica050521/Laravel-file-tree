<?php

use App\Http\Controllers\NodeController;
use Illuminate\Support\Facades\Route;

Route::get('/tree', [NodeController::class, 'tree']);
Route::get('/flat', [NodeController::class, 'flat']);
Route::post('/nodes', [NodeController::class, 'store']);
Route::delete('/nodes/{node}', [NodeController::class, 'destroy']);
