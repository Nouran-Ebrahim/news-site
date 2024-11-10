<?php

use App\Http\Controllers\Api\Account\SettingsController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\Password\ForgetPasswordController;
use App\Http\Controllers\Api\Password\RestPasswordController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum','CheckUserStatus'])->prefix('account')->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::get('/user/notifications', function (Request $request) {
        $notifications = auth()->user()->notifications;
        $unReadNotifiacations = auth()->user()->unreadNotifications;
        $data = [
            'notifications' => NotificationResource::collection($notifications),
            'unReadNotifiacations' => NotificationResource::collection($unReadNotifiacations)
        ];
        if ($notifications->count() == 0) {
            return apiResponse(200, 'No notifications');
        }

        return apiResponse(201, 'Notifications found', $data);
    });
    Route::get('/user/notification/read', function (Request $request) {
        $notification = auth()->user()->unreadNotifications()->where('id', $request->id)->first();
        if ($notification) {
            $notification->markAsRead();
            return apiResponse(200, 'Notification read');
        }
        return apiResponse(404, 'Notification not found');
    });
    Route::put('passwordUpdate', [SettingsController::class, 'passwordUpdate']);
    Route::put('settings', [SettingsController::class, 'updateSettings']);
});
Route::middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::get('/index', [PostController::class, 'index']);
    Route::post('/store', [PostController::class, 'store']);
    Route::delete('/destroy/{id}', [PostController::class, 'destroy']);
    Route::post('/storeComment', [PostController::class, 'storeComment']);

});
Route::post('auth/login', [LoginController::class, 'login']);
Route::delete('auth/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('auth/register', [RegisterController::class, 'register']);
Route::post('auth/email/virify', [RegisterController::class, 'emailVerfication'])->middleware('auth:sanctum');
Route::get('auth/email/send-otp-again', [RegisterController::class, 'sendOtpAgain'])->middleware('auth:sanctum');

Route::post('password/email', [ForgetPasswordController::class, 'sendOtp']);

Route::post('password/rest', [RestPasswordController::class, 'rest']);


Route::get('posts', [GeneralController::class, 'getPosts']);
Route::get('posts/show/{slug}', [GeneralController::class, 'showPost']);
Route::get('settings', [GeneralController::class, 'getSettings']);
Route::get('categories', [GeneralController::class, 'getCategories']);
Route::get('categories/{slug}/posts', [GeneralController::class, 'getCategoryPosts']);

Route::post('contacts/store', [GeneralController::class, 'storeContacts'])->middleware('throttle:contact');
