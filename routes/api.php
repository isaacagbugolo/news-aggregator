<?php
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\UserPreferenceController;

Route::prefix('v1')->group(function(){
    Route::get('articles', [ArticleController::class, 'index']); // search + filters
    Route::get('articles/{id}', [ArticleController::class, 'show']);
    Route::get('sources', [ArticleController::class, 'sources']);
    // auth routes and user preference routes (require auth)
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('me/preferences', [UserPreferenceController::class,'show']);
        Route::post('me/preferences', [UserPreferenceController::class,'update']);
    });
});
