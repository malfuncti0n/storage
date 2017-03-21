<?php

namespace App\Controllers;

class Controller
{
    protected $container;
    public function __construct($container)
    {
        $this->container = $container;
    }

    //this function give us access in container
    public function __get($property)
    {
        if ($this->container->{$property}){
            return $this->container->{$property};
        }
    }

    //helper function for json encoding and faster response
    public function jsonResponse($content = '', $httpStatus = 200, $response){
        $body = $response->getBody();
        $body->write(json_encode($content));
        return $this->response->withStatus($httpStatus)->withBody($body);
    }
}
