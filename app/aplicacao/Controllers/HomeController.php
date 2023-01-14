<?php

namespace InfluenceDigital\Controllers;

use InfluenceDigital\Libs\Helper;
use InfluenceDigital\Core\Model;


class HomeController
{
    private string $View = 'home/index';
    
    public function index()
    {
        $data = [
            'titulo' => "Home",
            'load'=> new Helper(),
        ];
        Helper::loadView($this->View, $data);
    } 
}