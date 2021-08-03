<?php 

class ChangeStatus extends PerfomRequest
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
        $this->uri = "http://localhost:8000/api/streamers/changeStatus";
    }

    public function getRequest(): RequestConnector
    {
        return new PostConnector($this->fields, $this->uri);
    }
}
