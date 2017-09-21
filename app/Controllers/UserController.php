<?php

namespace App\Controllers;

use App\Models\User;

use App\Presenters\UserPresenter;

use App\Presenters\ErrorPresenter;

use Respect\Validation\Validator as v;

class UserController extends Controller
{
    private $_cost = 10;



        public function get($request, $response)
    {
         //get url parameters
        $routeParams = $request->getAttribute('routeInfo')[2];
        // check if emty

        $validation = $this->validator->validateArray((array)$routeParams, [
        'username' => v::noWhitespace()->notEmpty(),
        'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed())
        {
            //if validation failed response back with the failure(bad request)
            return $this->fastResponse((new ErrorPresenter(['message' =>'Wrong input data']))->present(),400 ,$response);
        }

        //initialize new object
        $user=new User;

        //find user in database
        $userResult=$user->where('username', $routeParams['username'])->first();

        //if user not found redirect back with 404 status not fount
        if(empty($userResult)){
            return $this->fastResponse((new ErrorPresenter(['message' =>'No such user'])),404 ,$response);
        }

        $password_hashed = crypt(md5($routeParams['password']),md5($userResult->username));

        //if password match
        if ( $userResult->password == $password_hashed) {
            // get response body and send response in json format
            return $this->fastResponse((new UserPresenter($userResult))->present(), 200, $response);
        }
        //else response for wrong password
        return $this->fastResponse((new ErrorPresenter(['message' =>'Wrong Password']))->present(),400 ,$response);


    }

    //post request on users create new user
    public function post($request, $response){
        //get json data
        $json = $request->getBody();
        $data = json_decode($json, true);

        //validate data
         $validation = $this->validator->validateArray((array)$data, [
        'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
        'username'=> v::notEmpty()->alpha()->unameAvailable(),
        'firstname'=> v::notEmpty()->alpha(),
        'lastname'=> v::notEmpty()->alpha(),
        'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed())
        {
            //if validation failed response back with the failure
            return $this->fastResponse((new ErrorPresenter(['message' =>'data validation failed']))->present(),400 ,$response);
        }


        // Hash the password with the salt
        $password_hashed = crypt(md5($data['password']),md5($data['username']));
       // $password_hashed = password_hash($data['username'], PASSWORD_DEFAULT);
        //else create new user
        $user = new User;
        $user->email=$data['email'];
        $user->username=$data['username'];
        $user->firstname=$data['firstname'];
        $user->lastname=$data['lastname'];
        $user->password=$password_hashed;
        $user->token=bin2hex($data['email']);
        $user->save();
        return $this->fastResponse((new UserPresenter($user))->present(), 200, $response);

    }

    public function put($request, $response){
        $json = $request->getBody();
        $data = json_decode($json, true);
        var_dump($data);

        //validate data
        $validation = $this->validator->validateArray((array)$data, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'username'=> v::notEmpty()->alpha()->unameAvailable(),
            'firstname'=> v::notEmpty()->alpha(),
            'lastname'=> v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

    }

    public function delete($request, $response){
        die('delete');
    }
}
