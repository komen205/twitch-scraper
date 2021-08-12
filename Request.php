<?php

require_once __DIR__.'/vendor/autoload.php';
require_once 'Request/GetStreamers.php';
require_once 'Request/ChangeOnline.php';
require_once 'Request/ChangeStatus.php';
require_once 'Request/CreateSub.php';
require_once 'Request/TwitchOnline.php';

interface RequestConnector
{
    public function start(): void;

    public function finish(): string;
}
class PostConnector implements RequestConnector
{
    private $fields;
    private $uri;

    public function __construct(array $fields, string $uri)
    {
        $this->fields = $fields;
        $this->uri = $uri;
    }

    public function start(): void
    {
        $this->ch = curl_init(); //Initiates curl request
        curl_setopt($this->ch, CURLOPT_URL, $this->uri);
        $fields_string = http_build_query($this->fields);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function finish(): string
    {
        return curl_exec($this->ch);
    }
}
class GetConnector implements RequestConnector
{
    private $fields;
    private $uri;

    public function __construct(array $fields, string $uri)
    {
        $this->fields = $fields;
        $this->uri = $uri;
    }

    public function start(): void
    {
        $this->ch = curl_init(); //Initiates curl request
        curl_setopt($this->ch, CURLOPT_URL, $this->uri);
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->fields);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function finish(): string
    {
        return curl_exec($this->ch);
    }
}

abstract class PerfomRequest
{
    abstract public function getRequest(): RequestConnector;

    public function start()
    {
        $request = $this->getRequest();
        $request->start();

        return $request->finish();
    }
}
