<?php

namespace App\Presenters;

class UserPresenter extends BasePresenter{
    public function format(){
        return [
            'id' => $this->data->id,
            'email' => $this->data->email,
            'username' => $this->data->username,
            'firstname' => $this->data->firstname,
            'lastname' => $this->data->lastname,
            'User created' => $this->data->created_at
        ];
    }
}
