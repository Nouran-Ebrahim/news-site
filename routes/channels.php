<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//$user this is the auth user in guard web that will resive the notification
    return (int) $user->id === (int) $id;
});
Broadcast::channel('App.Models.Admin.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
},['guards'=>['admin']]);
//to ensure the auth user id is the same id pushed to pusher channel as the channel App.Models.user.id

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// },['guards' => ['web', 'admin']]); default gaurd is web and if there is anthor gaurd we must difine the gaurd name
