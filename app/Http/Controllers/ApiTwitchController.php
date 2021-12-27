<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;


use romanzipp\Twitch\Enums\GrantType;
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


     public function testss(Request $request)
    {

        $twitch = new Twitch;
        $user = Socialite::driver('twitch')->user();

        $resultado = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, ['channel:read:subscriptions', 'user:read:email']);

        $access_token = $resultado->data()->access_token;;

        // dd($access_token);

        $payload = [
            'type' => EventSubType::CHANNEL_FOLLOW,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => $user->id,
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => 'https://twitchapi.clustermx.com/api/twitch/eventsub/webhook',
                //'secret' => 'chenchosecret',
            ]
        ];


        // $result = $twitch->subscribeEventSub([],$payload);
        // $resultad = $twitch->getEventSubs(['status' => 'webhook_callback_verification_failed']);

        // $result = $twitch->withToken($access_token)->subscribeEventSub([],$payload);

        $pending = $twitch->withToken($access_token)->getEventSubs(['status' => 'webhook_callback_verification_failed']);
        $failed = $twitch->withToken($access_token)->getEventSubs(['status' => 'webhook_callback_verification_pending']);
        $enabled  = $twitch->withToken($access_token)->getEventSubs(['status' => 'enabled']);
        $exceeded  = $twitch->withToken($access_token)->getEventSubs(['status' => 'notification_failures_exceeded']);
        $urevoked  = $twitch->withToken($access_token)->getEventSubs(['status' => 'user_removed']);
        $revoked  = $twitch->withToken($access_token)->getEventSubs(['status' => 'authorization_revoked']);



        // $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

        // dd($payload, $result);
        dd($pending, $failed, $enabled, $exceeded, $urevoked, $revoked);
    }

    public function testsss(Request $request)
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'user:read:email',
            'user:edit:follows',
            'channel:read:subscriptions'
        ]);

        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_FOLLOW,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => '41726771', // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => 'https://twitchapi.clustermx.com/api/twitch/eventsub/webhook',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

        dd($payload, $result);
    }


    public function test(Request $request)
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'user:read:email',
            'user:edit:follows',
            'channel:read:subscriptions'
        ]);

        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_FOLLOW,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => '41726771', // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => config('app.url') . '/twitch/eventsub/webhook',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

        dd($payload, $result);
    }





}
