<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once('Request.php');

function clientCode(PerfomRequest $request)
{
    return $request->start();
}

$fields = ['streamer' => 'xqcow', 'run' => '1'];
$fieldsget = [];
$result = clientCode(new GetStreamers($fieldsget));
dump($result);
