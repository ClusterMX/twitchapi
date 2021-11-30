<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use Symfony\Component\HttpFoundation\Response;

use Log;

class EventSubController extends BaseController
{


    public function handleWebhookRedeem(Request $request): Response {



        $payload = json_decode($request->getContent(), true);

        $messageType = $request->header('twitch-eventsub-message-type');
        $messageId = $request->header('twitch-eventsub-message-id');
        $retries = (int) $request->header('twitch-eventsub-message-retry');
        $timestamp = Carbon::createFromTimestampUTC(
                        EventSubSignature::getTimestamp($request->header('twitch-eventsub-message-timestamp')));

        if ('notification' === $messageType) {
            $messageType = sprintf('%s.notification', $payload['subscription']['type']);
        }

        $method = 'handle' . Str::studly(str_replace('.', '_', $messageType));

        EventSubReceived::dispatch($payload, $messageId, $retries, $timestamp);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            EventSubHandled::dispatch($payload, $messageId, $retries, $timestamp);

            Log::info($response);

            return $response;

        }

        Log::info($this->missingMethod());

        return $this->missingMethod();

    }
}
