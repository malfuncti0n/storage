<?php

namespace App\Controllers;


class FacebookUserController extends UserController{

    public function post($request, $response){
        var_dump($request->getParsedBody());
        die();
    }
}
