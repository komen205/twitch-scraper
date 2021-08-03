<?php

use GhostZero\Tmi\Client;
use GhostZero\Tmi\ClientOptions;
use GhostZero\Tmi\Events\Twitczh\SubEvent;
use GhostZero\Tmi\Events\Twitch\AnonSubGiftEvent;
use GhostZero\Tmi\Events\Twitch\AnonSubMysteryGiftEvent;
use GhostZero\Tmi\Events\Twitch\ResubEvent;
use GhostZero\Tmi\Events\Twitch\SubGiftEvent;
use GhostZero\Tmi\Events\Twitch\SubMysteryGiftEvent;

class TwitchIRC
{
    public static function create()
    {

        $client = new Client(new ClientOptions([
            'options' => ['debug' => false],
            'connection' => [
                'secure' => true,
                'reconnect' => true,
                'rejoin' => true,
            ],
            'channels' => [$GLOBALS['streamer']]
        ]));

        /**
         * @param SubGiftEvent $event
         */
        function giftedRequest($event, $type): void
        {

            $fields = ['recipient' => $event->recipient, 'plan' => $event->plan->plan, 'gifttype' => $type, 'gifter' => $event->user];
            CreateRequest::createSub($fields);
        }

        /**
         * @param SubEvent $event
         */
        function subbedRequest($event, $type): void
        {
            $fields = ['recipient' => $event->user, 'plan' => $event->plan->plan, 'gifttype' => $type, 'gifter' => NULL, 'streamer' => $GLOBALS['streamer']];
            dump($fields);
            CreateRequest::createSub($fields);
        }

        $client->on(SubEvent::class, function (SubEvent $event) {
            subbedRequest($event, 'SubEvent');
        });
        $client->on(AnonSubGiftEvent::class, function (AnonSubGiftEvent $event) {
            print_r($event);
        });

        $client->on(AnonSubMysteryGiftEvent::class, function (AnonSubMysteryGiftEvent $event) {
            print_r($event);
        });
        $client->on(ResubEvent::class, function (ResubEvent $event) {
            subbedRequest($event, 'ResubEvent');
        });
        $client->on(SubGiftEvent::class, function (SubGiftEvent $event) {
            giftedRequest($event, 'SubGiftEvent');
        });
        $client->on(SubMysteryGiftEvent::class, function (SubMysteryGiftEvent $event) {
            subbedRequest($event, 'SubMysteryGiftEvent');
        });
        $client->connect();
    }
}