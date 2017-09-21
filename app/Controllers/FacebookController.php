<?php

namespace App\Controllers;


class FacebookController extends Controller{

    public function post($request, $response){
        var_dump($request->getParsedBody());
        die();
    }
}
