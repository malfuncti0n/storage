<?php

namespace App\Controllers;

use App\Models\User;

use App\Presenters\UserPresenter;

class UserController extends Controller
{


        public function get($request, $response)
    {
        die('get');
    }

    //post request on users create new user
    public function post($request, $response){
        $json = $this->request->getBody();
        $data = json_decode($json, true);
        $user = new User;
        $user->email=$data['email'];
        $user->username=$data['username'];
        $user->firstname=$data['firstname'];
        $user->lastname=$data['lastname'];
        $user->password=$data['password'];
        $user->save();
        return $this->fastResponse((new UserPresenter($user))->present(), 200, $response);

    }

    public function put($request, $response){
       die('put');
    }

    public function delete($request, $response){
        die('delete');
    }
}
