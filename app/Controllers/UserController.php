<?php

namespace App\Controllers;

use App\Models\User;

use App\Presenters\UserPresenter;

class UserController extends Controller
{


        public function get($request, $response)
    {
                //get article id
        $routeParams = $request->getAttribute('routeInfo')[2];
        //find in database
        $user=new User;
        if(is_null($routeParams['id'])){
            return $this->fastResponse(null,403 ,$response);
        }
        $userResult=$user->find($routeParams['id']);

        //if article not found redirect back with 404 status
        if(empty($userResult)){
            return $this->fastResponse(null,404 ,$response);
        }
        //else get response body and send response in json format
        return $this->fastResponse((new UserPresenter($userResult))->present(), 200, $response);
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
