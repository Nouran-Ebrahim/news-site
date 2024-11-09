<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\Passwords\RestPasswordController;
use App\Http\Controllers\Admin\Autherization\AutherizationController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\GeneralSearchController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Notifications\NotificationController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\SettingsController;
use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Auth\VerificationController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\Passwords\ForgetPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::redirect('/admin', '/login'); // this impostant as when i visit / he put home autmaticly and vite home page
Route::group(
    [
        'as' => 'admin.',
        'prefix' => 'admin',
        // 'middleware' => ['guest:admin'],

    ]
    ,
    function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
        Route::post('/submit', [LoginController::class, 'login'])->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
            Route::get('email', [ForgetPasswordController::class, 'showEmailForm'])->name('showEmailForm');
            Route::post('email', [ForgetPasswordController::class, 'sendOtp'])->name('sendOtp');
            Route::get('confirm/{email}', [ForgetPasswordController::class, 'showConfirmForm'])->name('showConfirmForm');
            Route::post('confirm/', [ForgetPasswordController::class, 'verifyOtp'])->name('verifyOtp');
            Route::get('rest/{email}', [RestPasswordController::class, 'showRestForm'])->name('showRestForm');
            Route::post('rest/', [RestPasswordController::class, 'rest'])->name('rest');

        });
    }

);
Route::group(
    [
        'as' => 'admin.',
        'prefix' => 'admin',
        'middleware' => ['auth:admin','CheckAdminStatus'],

    ]
    ,
    function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('can:home');
        Route::get('search', [GeneralSearchController::class, 'index'])->name('search');

        Route::resource('autherizations', AutherizationController::class)->middleware('can:autherizations');

        Route::resource('users', UserController::class)->middleware('can:users');
        Route::resource('categories', CategoryController::class)->middleware('can:categories');
        Route::resource('posts', PostController::class);
        Route::resource('admins', AdminController::class)->middleware('can:admins');

        Route::get('posts/toggleStatus/{post}', [PostController::class, 'toggleStatus'])->name('posts.toggleStatus')->middleware('can:posts');
        Route::get('posts/comments/{id}', [PostController::class, 'deleteComment'])->name('posts.deleteComment')->middleware('can:posts');
        Route::post('posts/image/delete', [PostController::class, 'deletePostImage'])->name('posts.image.delete');
        Route::get('posts/getAllcomments/{post}', [PostController::class, 'getAllcomments'])->name('posts.getAllcomments');

        Route::get('categories/toggleStatus/{category}', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
        Route::get('users/toggleStatus/{user}', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::get('admins/toggleStatus/{admin}', [AdminController::class, 'toggleStatus'])->name('admins.toggleStatus');


        Route::controller(SettingsController::class)->prefix('settings')->middleware('can:settings')->name('settings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update', 'update')->name('update');
        });
        Route::controller(ContactController::class)->prefix('contacts')->middleware('can:contacts')->name('contacts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{contact}', 'show')->name('show');
            Route::post('/destroy/{contact}', 'destroy')->name('destroy');

        });
        Route::controller(ProfileController::class)->prefix('profile')->middleware('can:profile')->name('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update', 'update')->name('update');
        });
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', NotificationController::class)->name('index')->middleware('can:notifications');
            Route::post('/delete', [HomeController::class, 'deleteNotification'])->name('delete')->middleware('can:notifications');
            Route::get('/deleteAll', [HomeController::class, 'deleteAll'])->name('deleteAll')->middleware('can:notifications');


        });
        //  Route::post('/logout',[LoginController::class,'logout'])->name('logout');

    }

);







