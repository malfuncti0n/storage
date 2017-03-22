<?php

namespace App\Presenters;

class BasePresenter{
    protected $data;

    public function __construct($data = []){
        //convert array to object if no object given
        $this->data = (object)$data;
    }

    public function present(){
        return json_encode($this->format());
    }

}
