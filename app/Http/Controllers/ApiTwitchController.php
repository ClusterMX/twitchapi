<?php

namespace App\Http\Controllers;

use App\Models\EventSub;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;


use romanzipp\Twitch\Enums\GrantType;
use romanzipp\Twitch\Twitch;
use romanzipp\Twitch\Enums\EventSubType;

//modelos
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Log;

class ApiTwitchController extends Controller
{
    public function check(Request $request)
    {

        $twitch = new Twitch;
        //$user = Socialite::driver('twitch')->user();

        $resultado = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, ['channel:read:subscriptions', 'user:read:email', 'channel:manage:redemptions', 'channel:read:redemptions']);

        $access_token = $resultado->data()->access_token;

        // dd($access_token);

        $payload = [
            'type' => EventSubType::CHANNEL_FOLLOW,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => '41726771',
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

    public function delete(Request $request)
    {
        $evento  = $request->get('idevent');
        //Elimina el evento
        $twitch = new Twitch;

        $twitch->unsubscribeEventSub([
            'id' => $evento
        ]);

        //Regresamos al formulario
        return redirect()->back();
    }

    public function eventoPrueba(Request $request)
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'channel:read:subscriptions',
            'user:read:email',
            'channel:manage:redemptions',
            'channel:read:redemptions'
        ]);


        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_ADD,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

        dd($payload, $result);
    }


    public function test()
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
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => config('app.url') . '/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

        dd($payload, $result);
    }


    public function login()
    {
        $twitchUser = Socialite::driver('twitch')->user();


        //buscamos si el usuario existe
        $user = User::where('twitch_id', $twitchUser->id)->first();

        if ($user) {

            //si existe, actualizá el token y el refresh token
            $user->update([
                'twitch_token' => $twitchUser->token,
                'twitch_refresh' => $twitchUser->refreshToken,
            ]);

        }else{

            $password = Hash::make(Str::random(10));
            //si no existe, guardamos el usuario en la base de datos
            $user = User::create([
                'name' => $twitchUser->name,
                'email' => $twitchUser->email,
                'twitch_id' => $twitchUser->id,
                'twitch_token' => $twitchUser->token,
                'twitch_refresh' => $twitchUser->refreshToken,
                'avatar' => $twitchUser->avatar,
                'password' => $password,
            ]);

        }

        Auth::login($user);

        //Realiza la suscripción a los eventos
        $this->EventoFollow();
        $this->EventoSubscription();
        $this->EventoSubMensaje();
        $this->EventoSubGif();
        $this->EventoCheer();
        $this->EventoRaid();
        $this->EventoHost();

        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $twitch = new Twitch;

        //Obtenemos Followers
        $followers = $twitch->withToken(Auth::user()->twitch_token)->getUsersFollows(['from_id' => Auth::user()->twitch_id])->getTotal();

        //Obtenemos Subs
        $subs = $twitch->withToken(Auth::user()->twitch_token)->getSubscriptions(['broadcaster_id' => Auth::user()->twitch_id])->getTotal();
        //Obtenemos los views
        $users = $twitch->getUsers(['id' => Auth::user()->twitch_id])->data();
        $viewcount = $users[0]->view_count;
        //Obtenemos los videos
        $videos = $twitch->getVideos(['user_id' => Auth::user()->twitch_id, 'type' => 'archive'])->data();
        $search  = array('%{width}', '%{height}');
        $replace = array('320', '180');

        //Obtenemos los eventos
        $events = EventSub::where('broadcaster_user_id', Auth::user()->twitch_id)->get();
        return view('dashboard.main', compact('followers', 'viewcount', 'subs', 'videos', 'search', 'replace', 'events'));
    }



    //Eventos

    public function EventoFollow()
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
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => config('app.url') . '/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);
    }

    public function EventoSubscription()
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'channel:read:subscriptions',
            'user:read:email',
            'channel:manage:redemptions',
            'channel:read:redemptions'
        ]);


        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_SUBSCRIBE,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);
    }

    public function EventoSubGif()
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'channel:read:subscriptions'
        ]);


        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_SUBSCRIPTION_GIFT,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

    }

    public function EventoSubMensaje()
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'channel:read:subscriptions',
            'user:read:email',
            'channel:manage:redemptions',
            'channel:read:redemptions'
        ]);


        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_SUBSCRIPTION_MESSAGE,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);
    }

    public function EventoCheer()
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'bits:read',
            'channel:read:subscriptions',
            'user:read:email',
            'channel:manage:redemptions',
            'channel:read:redemptions'
        ]);


        $token = $result->data()->access_token;


        $payload = [
            'type' => 'channel.cheer',
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

    }

    public function EventoRaid()
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, []);


        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_RAID,
            'version' => '1',
            'condition' => [
                'to_broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);

    }

    public function EventoHost()
    {
        $twitch = new Twitch;

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, [
            'channel:read:subscriptions',
            'user:read:email',
            'channel:manage:redemptions',
            'channel:read:redemptions'
        ]);


        $token = $result->data()->access_token;

        $payload = [
            'type' => EventSubType::CHANNEL_HOST,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => Auth::user()->twitch_id, // twitch
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' =>config('app.url').'/api/twitch/eventsub/webhook',
                'secret' => 'chenchosecret2510',
            ]
        ];

        $result = $twitch->withToken($token)->subscribeEventSub([], $payload);


    }



}
