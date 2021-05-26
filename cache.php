<?php

class Cache
{
    public $method;

    public $url;

    public $parameters;

    public $data;

    public $response;

    public $created_at;

    public function __construct($method, $url, $parameters = null, $data = null)
    {
        $this->method = $method;
        $this->url = $url;
        $this->parameters = $parameters;
        $this->data = $data;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function toString()
    {
        return "Method: " . $this->method . " URL: " . $this->url . " Parameters: " . $this->parameters . " Content: " . $this->data;
    }
}
