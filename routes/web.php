<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

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





//Se utiliza para crear el token y poder acceder
Route::get('/success', function (Request $request) {


    //Se obtiene el codigo de autorización
    $code_twitch = $request->get('code');
    $url = "https://id.twitch.tv/oauth2/token?client_id=".env('TWITCH_CLIENT_ID')."&client_secret=".env('TWITCH_CLIENT_SECRET')."&code=".$code_twitch."&grant_type=authorization_code&redirect_uri=".env('TWITCH_REDIRECT_URI')."/token";
    $client = new Client();
    $res = $client->post($url);
    $datos = json_decode($res->getBody()->getContents());

    $token = $datos->access_token;

    // Creo el request del oauth2 validate - https://id.twitch.tv/oauth2/validate y obtengo user_id
    $user = "https://id.twitch.tv/oauth2/validate";
    $u = $client->get($user, [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
        ],
    ]);

    $datosUsuario = json_decode($u->getBody()->getContents());

    $user_id = $datosUsuario->user_id;


    //Se obtienen los datos de los subs
    $subs = "https://api.twitch.tv/helix/subscriptions?broadcaster_id=".$user_id;

    $res = $client->get($subs, [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Client-Id'        => env('TWITCH_CLIENT_ID'),
        ],
    ]);

    $datos = json_decode($res->getBody()->getContents());

    $datos_subs  = $datos->data;




    return redirect()->route('board')->with( ['datos_subs' => $datos_subs] );

});


//Se obtiene el codigo generado
Route::post('/board', function (Request $request) {

    return $request->all();

})->name('board');

