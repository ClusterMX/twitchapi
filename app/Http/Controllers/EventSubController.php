<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Log;

class EventSubController extends BaseController
{
    /**
     * Handle a EventSub callback verification call.
     *
     * @param array $payload
     *
     * @return Response
     */
    protected function handleWebhookCallbackVerification(array $payload): Response
    {
        app('debugbar')->disable();
        return new Response($payload['challenge'], 200);
    }


    public function handleChannelFollowNotification(array $payload): Response
    {
        Log::info('handleChannelFollowNotification');
        //convertimos el array en un objeto
        Log::info($payload["event"]);

        return $this->successMethod(); // handle the channel follow notification...
    }

    public function handleChannelChannelPointsCustomRewardRedemptionAddNotification(array $payload): Response
    {
        Log::info('handleChannelChannelPointsCustomRewardRedemptionAddNotification');
        Log::info($payload);
        if ($payload["event"]["reward"]["id"] == 'c8ba3aa0-a688-496b-b87a-34402443c773') {
            Log::info("Success event");
        }
        return $this->successMethod();
    }
}
