<?php

class Mic
{
    public $colour;
    public $brand;
    public $light;
    public $usb_port;
    public $model;
    public $prize;


    public function setLight($light){
            
            $this->light == $light;
    }
    public function getmodel(){
          return $this->model;
    }
    public function setmodel($model){
        $this->model = ucwords($model);
    }
}

?>