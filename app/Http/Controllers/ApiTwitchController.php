<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;

use romanzipp\Twitch\Twitch;
use romanzipp\Twitch\Enums\EventSubType;

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

        $user_id = $request->get('user_id');
        $token = $request->get('token');
        //Se obtienen los datos de los subs
        $subs = "https://api.twitch.tv/helix/subscriptions?broadcaster_id=".$user_id;

        $client = new Client();
        $res = $client->get($subs, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Client-Id'        => env('TWITCH_CLIENT_ID'),
            ],
        ]);

        $datos = json_decode($res->getBody()->getContents());

        $datos_subs  = $datos->data;

        // return $datos_subs;

        /*
        user_name
        tier
        is_gift
        gifter_name
        */

        $contador = 0;

        /**
         * Datos a guardar:
         * broadcaster_id
         * broadcaster_name
         * tier
         * user_name
        */
        foreach ($datos_subs as $d) {

            //primero verificamos que el usuario existe o no

            //Verificar cuales estan suscritos o no

                //Si estan suscritos

                    //si existe

                        //Verificamos que haya cambios

                            //Si hay cambios, se actualiza

                            //Si no hay cambios, se queda igual



                    //si no existe

                        //Guardamos la info

                //Si no está suscrito se borra de la base de datos

        }

        return $datos_subs;

        return view('opciones.estrellas', compact('datos_subs'));

    }


     public function test(Request $request)
    {

        $user = Socialite::driver('twitch')->user();

        // dd($user);

        $payload = [
            'type' => EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_ADD,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => $user->id,
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => 'https://twitchapi.clustermx.com/api/twitch/eventsub/webhook',
                // 'secret' => 'chenchosecret',
            ]
        ];

        $result = $twitch->withToken($token)->getEventSubs(['status' => 'enabled']);

        // $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

        dd($payload, $result);
    }



}
