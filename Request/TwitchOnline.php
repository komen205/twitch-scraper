<?php

class TwitchOnline extends PerfomRequest
{
    private $fields;

    public function __construct(array $fields, string $streamer)
    {
        $this->fields = $fields;
        $this->uri = "https://api.twitch.tv/helix/streams/?user_login=" . $streamer;
    }

    public function getRequest(): RequestConnector
    {
        return new GetConnector($this->fields, $this->uri);
    }
}
