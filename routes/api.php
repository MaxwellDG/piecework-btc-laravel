<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController; 

Route::prefix('organization')->group(function () {
    Route::get('/', [OrganizationController::class, 'index']);
    Route::post('/', [OrganizationController::class, 'store']);
    Route::patch('/{id}', [OrganizationController::class, 'update']);
    Route::delete('/{id}', [OrganizationController::class, 'delete']);
});