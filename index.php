<?php
define('ROOT', getcwd() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'aplicacao' . DIRECTORY_SEPARATOR);
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

require ROOT . 'vendor/autoload.php';
require APP . 'config/config.php';

use InfluenceDigital\Core\Rotas;
$Rotas = new Rotas();


// ****************** HOME ************************//
$Rotas->Rota('GET', '', 'HomeController@index');
$Rotas->Rota('GET', 'home', 'HomeController@index');



// ****************** usuarios ********************//
$Rotas->Rota('GET', 'usuarios', 'UsuariosController@index');



// ****************** Método run() ****************//
$Rotas->run();




