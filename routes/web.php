<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\ApiTwitchController;

use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\EventSubController;
use romanzipp\Twitch\Enums\EventSubType;

use romanzipp\Twitch\Twitch;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


////////////////  LOGIN


Route::get('/auth/twitch/redirect', function () {
    return Socialite::driver('twitch')
    ->scopes(['channel:read:subscriptions', 'user:read:email'])
    ->redirect();
})->name('loginTwitch');

Route::get('/auth/twitch/callback', [ApiTwitchController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function ($id) {
        return 'dashboard';
    })->name('dashboard');
});


//////PRUEBAS


Route::get('/twitch/test', [ApiTwitchController::class, 'test']);

Route::get('/twitch/check', [ApiTwitchController::class, 'check']);

Route::get('/twitch/delete', [ApiTwitchController::class, 'delete'])->name('delete.event');

Route::get('/pruebalog', [ApiTwitchController::class, 'pruebaLog']);



// Route::get('/auth/twitch/callback', function () {
//     // $user = Socialite::driver('twitch')->user();

//     // $user->id;


//     // Get User by Username
//     // $result = $twitch->getUsers(['login' => $user->nickname]);

//     // Check, if the query was successful
//     // if ( ! $result->success()) {
//     //     return null;
//     // }

//     // Shift result to get single user data
//     // $data = $result->shift();

//     // return $data;

//     // $user->token


//     //crear evento

//     // $twitch = new Twitch;

//     // $result = $twitch->subscribeEventSub([], [
//     //     'type' => EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_ADD,
//     //     'version' => '1',
//     //     'condition' => [
//     //         'broadcaster_user_id' => $user->id,
//     //     ],
//     //     'transport' => [
//     //         'method' => 'webhook',
//     //         'callback' => 'https://twitchapi.clustermx.com/api/twitch/eventsub/webhook',
//     //         // 'secret' => 'chenchosecret',
//     //     ]
//     // ]);



//     // $result = $twitch->getEventSubs(['status' => 'enabled']);

//     // foreach ($result->data() as $item) {
//     //     // process the subscription
//     //     echo $item.'<br>';
//     // }

//     // $result = $twitch->unsubscribeEventSub([
//     //     'id' => 'e8282f98-41a7-46e7-b9d2-a6d721e973dd'
//     // ]);


//     // return $result->data();

//     // dd($result);
// });



// Route::get(
//     '/notificación',
//     [EventSubController::class, 'handleNotification']
// );

Route::get('/lista', function () {
    $user = Socialite::driver('twitch')->user();
    $twitch = new Twitch;

    $result = $twitch->getEventSubs(['status' => 'notification_failures_exceeded']);

    foreach ($result->data() as $item) {
        // process the subscription
        echo $item.'<br>';
    }
});


//twitch event verify-subscription subscribe -F http://apitwitch.test/api/twitch/eventsub/webhook -s chenchosecret
//twitch event trigger subscribe -F http://apitwitch.test/api/twitch/eventsub/webhook -s chenchosecret







///////////////



Route::get('/success', [ApiTwitchController::class, 'tokenGenerator'])->name('success');


Route::get('/opciones', function (Request $request) {
    return $request->all();
})->name('opciones');

Route::post('/estrellas', [ApiTwitchController::class, 'subsInfo'])->name('estrellas');

//Se utiliza para crear el token y poder acceder
// Route::get('/success', function (Request $request) {


//     return redirect()->route('board', [$datos_subs]);

// });


//Se obtiene el codigo generado
Route::get('/board', function (Request $request) {

    $datos_subs = $request->get('datos_subs');

    return $datos_subs[0]->user_name;

})->name('board');

