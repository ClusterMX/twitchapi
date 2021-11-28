<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;

use Log;

class EventSubController extends Controller
{
    public function handleChannelFollowNotification(array $payload): Response
    {
        return $this->successMethod(); // handle the channel follow notification...
    }

    protected function handleNotification(array $payload): Response
    {
        return $this->successMethod(); // handle all other incoming notifications...
    }

    protected function handleRevocation(array $payload): Response
    {
        return $this->successMethod(); // handle the subscription revocation...
    }

    public function handleWebhook(Request $request){

        Log::info($request);

    }
}
