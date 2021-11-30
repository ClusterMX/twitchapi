<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;




class EventSubController extends BaseController
{
    /**
     * Handle a EventSub notification call.
     *
     * @param array $payload
     *
     * @return Response
     */
    protected function handleNotification(array $payload): Response
    {
        return $this->successMethod();
    }

    /**
     * Handle a EventSub revocation call.
     *
     * @param array $payload
     *
     * @return Response
     */
    protected function handleRevocation(array $payload): Response
    {
        return $this->successMethod();
    }


}
