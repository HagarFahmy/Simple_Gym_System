<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Notifications\Greetings;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Registration and login routes
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

// Email verifications routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    $user = Auth::user();
    Auth::login($user);
    Notification::send($user, new Greetings($user));
    return response(['success' =>  "Your email verified successfully"]);
})->middleware(['auth:sanctum'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:sanctum'])->name('verification.send');


Route::controller(UserController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    // Remaining training of the logged user sessions route
    Route::get('/training-sessions', 'remainingTrainingSessionsOfTheUser');
    // Sessions history of the user logged route
    Route::get('/sessions-history', 'getAttendanceHistoryOfTheUser');
    // Update user information data route
    Route::post("update", 'update');
});
