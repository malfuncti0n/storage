<?php

namespace App\Presenters;

class UserPresenter extends BasePresenter{
    public function format(){
        return [
            'message'=>$this->data->message,
            'id' => $this->data->id,
            'token' => $this->data->token,
            'email' => $this->data->email,
            'username' => $this->data->username,
            'firstname' => $this->data->firstname,
            'lastname' => $this->data->lastname,
            'User created' => $this->data->created_at,
            'user_accounts' =>[$this->data->user_accounts()->get()]

        ];
    }
}
