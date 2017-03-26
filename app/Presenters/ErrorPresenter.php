<?php

namespace App\Presenters;

class ErrorPresenter extends BasePresenter{
    public function format(){
        return [
            'message' => $this->data->message
        ];
    }
}
