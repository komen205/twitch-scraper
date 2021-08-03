<?php 

class GetStreamers extends PerfomRequest
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields  = $fields;
        $this->uri = "http://localhost:8000/api/streamers/getAll";
    }

    public function getRequest(): RequestConnector
    {
        return new GetConnector($this->fields, $this->uri);
    }
}
