<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use App\Events\PointsReward;

use App\Http\Controllers\ApiTwitchController;
use Illuminate\Support\Facades\Log;
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
    return view('auth.login');
})->name('login');

Route::get('/example', function () {
    return view('welcome');
});

Route::get('/delet', function () {
    return view('index');
});

Route::get('/master', function () {

    event(new PointsReward());
    return 'fired';
    // $array = array (
    //     'subscription' =>
    //     array (
    //       'id' => 'f3bf522a-b370-4cec-b907-87408b39f023',
    //       'status' => 'enabled',
    //       'type' => 'channel.follow',
    //       'version' => '1',
    //       'condition' =>
    //       array (
    //         'broadcaster_user_id' => '41726771',
    //       ),
    //       'transport' =>
    //       array (
    //         'method' => 'webhook',
    //         'callback' => 'https://twitchapi.clustermx.com/api/twitch/eventsub/webhook',
    //       ),
    //       'created_at' => '2021-12-27T04:34:51.378035566Z',
    //       'cost' => 0,
    //     ),
    //     'event' =>
    //     array (
    //       'user_id' => '753201185',
    //       'user_login' => 'chenchizkanbot',
    //       'user_name' => 'chenchizkanbot',
    //       'broadcaster_user_id' => '41726771',
    //       'broadcaster_user_login' => 'chenchizkan',
    //       'broadcaster_user_name' => 'chenchizkan',
    //       'followed_at' => '2022-01-09T02:02:13.761577223Z',
    //     ),
    // );

    // return $array["subscription"];
});



////////////////  LOGIN


Route::get('/auth/twitch/redirect', function () {
    return Socialite::driver('twitch')
    ->scopes(["user:read:email", "user:edit:follows", "channel:read:subscriptions", "channel:read:redemptions"])
    ->redirect();
})->name('loginTwitch');

Route::get('/auth/twitch/callback', [ApiTwitchController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [ApiTwitchController::class, 'dashboard'])->name('dashboard');

    //Rutas prueba
    Route::get('/evento', [ApiTwitchController::class, 'eventoPrueba']);
    Route::get('/evento-check', [ApiTwitchController::class, 'check']);


});


//////PRUEBAS


Route::get('/twitch/test', [ApiTwitchController::class, 'EventoSubGif']);

Route::get('/twitch/check', [ApiTwitchController::class, 'check']);

Route::get('/twitch/delete', [ApiTwitchController::class, 'delete'])->name('delete.event');


Route::get('pruebalog', function () {
    // Log::error("Info");
});



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

