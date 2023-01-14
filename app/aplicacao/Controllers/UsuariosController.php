<?php

namespace InfluenceDigital\Controllers;

use InfluenceDigital\Libs\Helper;


class UsuariosController 
{
    private string $View = 'usuarios/index';
    
    public function index()
    {
        Helper::view($this->View);
    }
}