<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\ApiTwitchController;
use Laravel\Socialite\Facades\Socialite;


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



});

Route::get('/auth/twitch/callback', function () {
    $user = Socialite::driver('twitch')->user();
    return json_encode($user);

    // $user->token
});




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

