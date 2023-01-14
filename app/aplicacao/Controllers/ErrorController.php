<?php

namespace InfluenceDigital\Controllers;

use InfluenceDigital\Libs\Helper;

class ErrorController
{
    private string $View = 'error/index';

    public function index()
    {
        Helper::redirecionar($this->View);        
    }
}