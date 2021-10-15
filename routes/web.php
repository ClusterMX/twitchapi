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


    $code_twitch = $request->get('code');
    $url = "https://id.twitch.tv/oauth2/token?client_id=".env('TWITCH_CLIENT_ID')."&client_secret=".env('TWITCH_CLIENT_SECRET')."&code=".$code_twitch."&grant_type=authorization_code&redirect_uri=".env('TWITCH_REDIRECT_URI')."/token";





    $client = new Client();
    $res = $client->post($url);

    $datos = json_decode($res->getBody()->getContents());


    $token = $datos->access_token;

    // $headers = [
    //     'Authorization' => 'Bearer ' . $token,
    // ];


    // $data = $client->get($url, $headers);
    // $datosSubs = json_decode($data->getBody()->getContents());


    return redirect()->route('datos', ['token' => $token]);
    // return $code_twitch;

    // return Redirect::to($url);
    // return view('token',compact('code_twitch'));



    // dd($url);
});


//Se obtiene el codigo generado
Route::get('/datos', function (Request $request) {

    $token = $request->get('token');


    $subs = "https://api.twitch.tv/helix/subscriptions?broadcaster_id=41726771";

    $client = new Client();

    $headers = [
        'Authorization' => 'Bearer ' . $token,
        'Client-Id'        => env('TWITCH_CLIENT_ID'),
    ];


    $res = $client->get($subs, [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Client-Id'        => env('TWITCH_CLIENT_ID'),
        ],
    ]);

    $datos = json_decode($res->getBody()->getContents());



    return $datos;





})->name('datos');

