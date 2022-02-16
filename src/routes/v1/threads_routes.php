<?php

use Illuminate\Support\Facades\Route;


Route::resource('threads','App\Http\Controllers\api\v1\thread\ThreadController');

Route::prefix('/threads')->group(function (){
    Route::resource('answers','App\Http\Controllers\api\v1\thread\AnswerController');

    Route::post('/{thread}/subscribe','App\Http\Controllers\api\v1\thread\SubscribeController@subscribe')->name('subscribe');
    Route::post('/{thread}/unsubscribe','App\Http\Controllers\api\v1\thread\SubscribeController@unSubscribe')->name('unSubscribe');

});
