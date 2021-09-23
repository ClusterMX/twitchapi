<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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



//Envia los datos para generar el codigo y solicitar los permisos para la información de twitch
Route::get('/success', function (Request $request) {


    $code_twitch = $request->get('code');
    $url = "https://id.twitch.tv/oauth2/token?client_id=".env('TWITCH_CLIENT_ID')."&client_secret=".env('TWITCH_CLIENT_SECRET')."&code=".$code_twitch."&grant_type=authorization_code&redirect_uri=".env('TWITCH_REDIRECT_URI')."/token";

    // return $code_twitch;

    // return Redirect::to($url);
    // return view('token',compact('code_twitch'));

    $urlencode = urlencode($url);

    $json = json_decode(file_get_contents($urlencode), true);

    dd($json);
});


//Se obtiene el codigo generado
Route::get('/token', function (Request $request) {
    // $code = $request->get('code');
    // $url = env('TWITCH_REDIRECT_URI')."/token?code=".$code;

    // return Redirect::to($url);

    return $request->all();

});

