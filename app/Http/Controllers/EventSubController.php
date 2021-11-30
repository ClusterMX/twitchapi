<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;

use romanzipp\Twitch\Events\EventSubHandled;
use romanzipp\Twitch\Events\EventSubReceived;
use romanzipp\Twitch\Http\Middleware\VerifyEventSubSignature;
use romanzipp\Twitch\Objects\EventSubSignature;


class EventSubController extends BaseController
{
    public function handleChannelFollowNotification(array $payload): Response
    {
        return $this->successMethod(); // handle the channel follow notification...
    }


    protected function handleNotification(array $payload): Response
    {
        return $this->successMethod();
    }

    protected function handleRevocation(array $payload): Response
    {
        return $this->successMethod(); // handle the subscription revocation...
    }


}
