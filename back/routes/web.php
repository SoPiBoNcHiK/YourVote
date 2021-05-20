<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 
use App\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::post('/get_token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});

Route::get('/', 'VoteController@showAll');

Route::get('/vote/show/{id}', 'VoteController@show');

Route::get('/vote/create', function(){
    return view('create_vote');
});

Route::get('/vote/positive_inc/{id}', 'VoteController@increasePositive');
Route::get('/vote/negative_inc/{id}', 'VoteController@increaseNegative');

Route::post('/vote/create', 'VoteController@create');
