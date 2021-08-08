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


Route::get('/success', function (Request $request) {
    $code = $request->get('code');
    $url = "https://twitchapi.clustermx.com/token?code=".$code;

    return Redirect::to($url);

});

Route::post('/token', function (Request $request) {

    $code = $request->get('code');
    $url = "https://id.twitch.tv/oauth2/token?client_id=usgzw5f481gonmhmlwkm93gifo0d6t&client_secret=owf2oqgzmajnlyyl6upkjux0ec2u9y&code=".$code."&grant_type=authorization_code&redirect_uri=https://twitchapi.clustermx.com/success";

    return Redirect::to($url);
});
