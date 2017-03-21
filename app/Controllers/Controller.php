<?php

namespace App\Controllers;

class Controller{
    protected $request;
    protected $response;
    protected $container;

    public function __construct($request, $response, $container){
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }
}
