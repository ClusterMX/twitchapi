<?php

namespace App\Http\Controllers;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;

//Eventos
use App\Events\PointsReward;
use App\Models\EventSub;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventSubController extends BaseController
{
    public function handleChannelFollowNotification(array $payload): Response
    {
        Log::info('handleChannelFollowNotification');
        //convertimos el array en un objeto
        Log::info($payload["event"]);

        $evento = new EventSub;
        $evento->event_id = $payload["subscription"]["id"];
        $evento->broadcaster_user_id = $payload["event"]["broadcaster_user_login"];
        $evento->broadcaster_user_name = $payload["event"]["broadcaster_user_name"];
        $evento->type = $payload["subscription"]["type"];
        $evento->user_id = $payload["event"]["user_id"];
        $evento->user_name = $payload["event"]["user_name"];
        $evento->followed_at = $payload["event"]["followed_at"];
        $evento->save();

        return $this->successMethod(); // handle the channel follow notification...
    }

    public function handleChannelChannelPointsCustomRewardRedemptionAddNotification(array $payload): Response
    {
        Log::info('handleChannelChannelPointsCustomRewardRedemptionAddNotification');
        Log::info($payload);
        if ($payload["event"]["reward"]["id"] == 'c8ba3aa0-a688-496b-b87a-34402443c773') {
            event(new PointsReward());
        }
        return $this->successMethod();
    }
}
