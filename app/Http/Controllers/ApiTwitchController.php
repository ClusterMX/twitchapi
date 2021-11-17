<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiTwitchController extends Controller
{


    public function tokenGenerator(Request $request)
    {
        //Se obtiene el codigo de autorización
        $code_twitch = $request->get('code');
        $url = "https://id.twitch.tv/oauth2/token?client_id=".env('TWITCH_CLIENT_ID')."&client_secret=".env('TWITCH_CLIENT_SECRET')."&code=".$code_twitch."&grant_type=authorization_code&redirect_uri=".env('TWITCH_REDIRECT_URI')."/token";
        $client = new Client();
        $res = $client->post($url);
        $datos = json_decode($res->getBody()->getContents());
        $token = $datos->access_token;


        // Creo el request del oauth2 validate - https://id.twitch.tv/oauth2/validate y obtengo user_id
        $client = new Client();
        $user = "https://id.twitch.tv/oauth2/validate";
        $u = $client->get($user, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        $datosUsuario = json_decode($u->getBody()->getContents());

        $user_id = $datosUsuario->user_id;


        // return redirect()->route('opciones', ['user_id' => $user_id, 'token' => $token]);

        return view('opciones', compact('user_id', 'token'));



    }


    public function userInfo(Request $request)
    {
        // // Creo el request del oauth2 validate - https://id.twitch.tv/oauth2/validate y obtengo user_id
        // $client = new Client();
        // $user = "https://id.twitch.tv/oauth2/validate";
        // $u = $client->get($user, [
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . $token,
        //     ],
        // ]);

        // $datosUsuario = json_decode($u->getBody()->getContents());

        // $user_id = $datosUsuario->user_id;

    }

    public function subsInfo(Request $request)
    {
        return $request->all();
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

        return $datos_subs;

    }
}
