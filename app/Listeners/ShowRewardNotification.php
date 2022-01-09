<?php

namespace App\Listeners;

use App\Events\PointsReward;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShowRewardNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PointsReward  $event
     * @return void
     */
    public function handle(PointsReward $event)
    {
        //
    }
}
