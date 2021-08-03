<?php
require_once(__DIR__ . '/vendor/autoload.php');

include('CreateRequest.php');
include('TwitchScraper.php');



class Main
{
    public static function start()
    {
        
        $streamers = json_decode(CreateRequest::getAllStreamers());
        for ($i = 0; $i <= count($streamers) - 1; ++$i) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                die('could not fork');
            } else if ($pid) {
                // we are the parent
                // pcntl_wait($status); //Protect against Zombie children
            } else {
                $GLOBALS['streamer'] = ($streamers[$i]->streamer);
                cli_set_process_title($GLOBALS['streamer'] . 'run.php');

                if (empty(json_decode(CreateRequest::checkIfTwitchOnline($GLOBALS['streamer']))->data)) {
                    CreateRequest::updateStatus($GLOBALS['streamer'], '0');
                    CreateRequest::updateOnline($GLOBALS['streamer'], '0');
                    die();
                }
                echo('[*] Bot started for: '. $GLOBALS['streamer']."\n");
                CreateRequest::updateStatus($GLOBALS['streamer'], '1');
                CreateRequest::updateOnline($GLOBALS['streamer'], '1');
                TwitchIRC::create();
            }
        }
    }
}
Main::start();
