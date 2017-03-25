<?php

namespace App\Controllers;

class Controller
{
    protected $_methods=[
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'OPTIONS'
    ];



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
    public function fastResponse($content = '', $httpStatus = 200, $response){
        $body = $response->getBody();
        $body->write($content);

        return $this->response->withStatus($httpStatus)->withBody($body)->withHeader('Content-Type', 'application/json');

    }

     //get all routes on current controller and call the apropriate method if allowed
      public function getCall($request, $response){
        if(!in_array($method=$request->getMethod(),$this->_methods)){
            //if method not in array not allowed
            return $this->response->withStatus(405);
        }
        //call dynamically apropriate method
        return $this->$method($request, $response);

    }
}
