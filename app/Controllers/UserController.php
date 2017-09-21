<?php

namespace App\Controllers;

use App\Models\User;

use App\Presenters\UserPresenter;

use App\Presenters\ErrorPresenter;

use Respect\Validation\Validator as v;

use \Firebase\JWT\JWT;

class UserController extends Controller
{
    private $_cost = 10;
    //variables for jwt token
    private $_secretKey='secret';
    private $_algorithm='HS512';



        public function get($request, $response)
    {
         //get url parameters
        $routeParams = $request->getAttribute('routeInfo')[2];
        // check if emty

        $validation = $this->validator->validateArray((array)$routeParams, [
        'username' => v::noWhitespace()->notEmpty(),
        'password' => v::noWhitespace()->notEmpty(),
        ]);


        $body = $response->getBody();
        if ($validation->failed())
        {
            //if validation failed response back with the failure(bad request)
          //  return $this->fastResponse((new ErrorPresenter(['message' =>'Wrong input data']))->present(),400 ,$response);

            $body->write((new ErrorPresenter(['message' =>'data validation fail']))->present());
            return $this->response->withStatus(400)->withBody($body)->withHeader('Content-Type', 'application/json');
        }

        //initialize new object
        $user=new User;

        //find user in database
        $userResult=$user->where('username', $routeParams['username'])->first();

        //if user not found redirect back with 404 status not fount
        if(empty($userResult)){
            $body->write((new ErrorPresenter(['message' =>'No such user']))->present());
            return $this->response->withStatus(404)->withBody($body)->withHeader('Content-Type', 'application/json');
            //return $this->fastResponse((new ErrorPresenter(['message' =>'No such user'])),404 ,$response);
        }

        $password_hashed = crypt(md5($routeParams['password']),md5($userResult->username));

        //if password match
        if ( $userResult->password == $password_hashed) {
            // get response body and send response in json format

            //create a web token to send with the response
            $tokenId    = base64_encode(random_bytes(32)); //random id
            $issuedAt   = time();
            $notBefore  = $issuedAt + 10;  //Adding 10 seconds
            $expire     = $notBefore + 7200; // Adding 7200 seconds
            $serverName ='https://api-storage.herokuapp.com/';

            $data = [
                    'iat'  => $issuedAt,         // Issued at: time when the token was generated
                    'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                    'iss'  => $serverName,       // Issuer
                    'nbf'  => $notBefore,        // Not before
                    'exp'  => $expire,           // Expire
                    'data' => [                  // Data related to the logged user you can set your required data
				    'id'   => $userResult->id   , // id from the users table
				    'username' => $userResult->username, //  username
                    'email'=> $userResult->email
                                  ]
                    ];

            //here is happend the creation

              $jwt = JWT::encode(
                            $data, //Data to be encoded in the JWT
                            $this->_secretKey, // The signing key
                            $this->_algorithm
                           );

            $userResult->token=$jwt;
            $userResult->message='succesfully logged in';
            $body->write((new UserPresenter($userResult))->present());
            return $this->response->withStatus(200)->withBody($body)->withHeader('Content-Type', 'application/json');
           // return $this->fastResponse((new UserPresenter($userResult))->present(), 200, $response);
        }

        //else response for wrong password
        $body->write((new ErrorPresenter(['message' =>'Wrong Password']))->present());
        return $this->response->withStatus(200)->withBody($body)->withHeader('Content-Type', 'application/json');
       // return $this->fastResponse((new ErrorPresenter(['message' =>'Wrong Password']))->present(),400 ,$response);


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

        $body = $response->getBody();
        if ($validation->failed())
        {
            //if validation failed response back with the failure
            $body->write((new ErrorPresenter(['message' =>'data validation fail']))->present());
            return $this->response->withStatus(400)->withBody($body)->withHeader('Content-Type', 'application/json');
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
        $user->loginType=$data['loginType'];
        $user->password=$password_hashed;
       // $user->token=bin2hex($data['email']);
        $user->save();
        $user->message='succesfully created';
            //token creation for logged in
                    $data = [
                    'iat'  => $issuedAt,         // Issued at: time when the token was generated
                    'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                    'iss'  => $serverName,       // Issuer
                    'nbf'  => $notBefore,        // Not before
                    'exp'  => $expire,           // Expire
                    'data' => [                  // Data related to the logged user you can set your required data
				    'id'   => $userResult->id   , // id from the users table
				    'username' => $userResult->username, //  username
                    'email'=> $userResult->email
                                  ]
                    ];

            //here is happend the creation

              $jwt = JWT::encode(
                            $data, //Data to be encoded in the JWT
                            $this->_secretKey, // The signing key
                            $this->_algorithm
                           );

        $user->token=$jwt;
        $body->write((new UserPresenter($user))->present());
        return $this->response->withStatus(200)->withBody($body)->withHeader('Content-Type', 'application/json');
       // return $this->fastResponse((new UserPresenter($user))->present(), 200, $response);

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
