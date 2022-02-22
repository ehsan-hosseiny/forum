<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\api\v1\user\UserController;


Route::prefix('/user')->group(function () {
    Route::get('/leaderboards', [UserController::class, 'leaderboard'])->name('users.leaderboard');
});
