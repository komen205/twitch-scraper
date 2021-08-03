<?php

include('Request.php');
function clientCode(PerfomRequest $request)
{
    return $request->start();
}
class CreateRequest
{


    public static function updateStatus($streamer, $status)
    {
        return clientCode(new ChangeStatus(['run' => $status, 'streamer' => $streamer]));
    }
    public static function updateOnline($streamer, $status)
    {
        return clientCode(new ChangeOnline(['is_online' => $status, 'streamer' => $streamer]));
    }

    public static function getAllStreamers()
    {
        return clientCode(new GetStreamers([]));
    }
    public static function checkIfTwitchOnline($streamer)
    {
        $fields = [
            'Authorization: Bearer gokyy7wxa9apriyjr2evaccv6h71qn',
            'Client-ID: gosbl0lt05vzj18la6v11lexhvpwlb'
        ];
        return clientCode(new TwitchOnline($fields, $streamer));
    }
    public static function createSub($fields)
    {
        return clientCode(new CreateSub([$fields]));
    }
}
