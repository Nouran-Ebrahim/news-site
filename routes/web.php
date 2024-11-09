<?php

use App\Http\Controllers\Admin\GeneralSearchController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\Dashboard\NotificationsController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsSubscribersController;
use App\Http\Controllers\Frontend\CategoryController;

use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::redirect('/', '/home'); // this impostant as when i visit / he put home autmaticly and vite home page
Route::group(
    [
        'as' => 'frontend.',

    ]
    ,
    function () {
        // Route::fallback(function(){
        //    abort(404);
        // });
        //verified middleware as we can not vist any page without virfing the user and must be auth first middleware(['auth', 'verified'])
        Route::get('/home', [HomeController::class, 'index'])->name('index');
        Route::post('storeSubscriber', [NewsSubscribersController::class, 'storeSubscriber'])->name('storeSubscriber');
        Route::get('category/{slug}', CategoryController::class)->name('categoryPosts');
        Route::group(['prefix' => 'post', 'as' => 'post.', 'controller' => PostController::class], function () {
            Route::get('/{slug}', 'show')->name('show');
            Route::get('/comments/{slug}', 'getAllcomments')->name('getAllcomments');
            Route::post('/comments/store', 'storeComments')->name('storeComments');
        });
        Route::group(['prefix' => 'contact', 'as' => 'contact.', 'controller' => ContactController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
        });


        //match  support get and post as when i refrech the search page after search gives an error as it is get method and search is post
        Route::match(['get', 'post'], 'search', SearchController::class)->name('search');
        Route::prefix('account/')->name('dashboard.')->middleware(['auth:web', 'verified','CheckUserStatus'])->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::get('profile', 'index')->name('profile');
                Route::post('post', 'storePost')->name('post.store');
                Route::get('post/edit/{slug}', 'editPost')->name('post.edit');
                Route::put('post/update', 'updatePost')->name('post.update');
                Route::post('post/delete', 'deletePost')->name('post.delete');
                Route::post('post/image/delete', 'deletePostImage')->name('post.image.delete');
                Route::get('post/getComments/{id}', 'getComments')->name('post.getComments');

            });
            Route::prefix('settings')->controller(SettingsController::class)->group(function () {
                Route::get('/', 'index')->name('settings');
                Route::post('/update', 'update')->name('settings.update');
                Route::post('/updatePassword', 'updatePassword')->name('settings.updatePassword');

            });
            Route::prefix('notifications')->name('notifications.')->controller(NotificationsController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/delete', 'delete')->name('delete');
                Route::get('/deleteAll', 'deleteAll')->name('deleteAll');

            });
        });

        Route::get('wait',function(){
         return view('frontend.wait');
        })->name('waitPage');
    }

);
Route::prefix('email')->name('verification.')->controller(VerificationController::class)->group(function () {
    Route::get('/verify', 'show')->name('notice');
    Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');
});



Auth::routes();
Route::get('/auth/{provider}/redirect',[SocialLoginController::class,'redirect'])->name('auth.google.redirect');
Route::get('/auth/{provider}/callback',[SocialLoginController::class,'callback'])->name('auth.google.callback');

Route::get('/auth/facebook/redirect',[SocialLoginController::class,'redirect'])->name('auth.facebook.redirect');
Route::get('/auth/facebook/callback',[SocialLoginController::class,'callback'])->name('auth.facebook.callback');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


