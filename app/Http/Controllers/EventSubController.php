<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;

use Log;

class EventSubController extends BaseController
{


    public function handleWebhookRedeem(Request $request){

        Log::info($request);

    }
}
