<?php

namespace InfluenceDigital\Core;

use InfluenceDigital\Libs\Helper;

/**
 * Classe pra gerenciar rotas 
 */

class Rotas 
{
     /**
     * @param $caminho vai receber o caminho da rota
     * @param $controlador Método do controller a ser acessado
     */

    private $route = [];
    private $param = [];
    private  $controller_path = "\\InfluenceDigital\\Controllers\\";
    private  $controller_error = "\\InfluenceDigital\\Controllers\\ErrorController";

    public function Rota($metodo, $caminho, $controlador, $param = []) {
        $rotas = $this->route[$metodo][$caminho] = [
                'controller' => $controlador,
                'parametro'=> $param
            ];  
        // var_dump($rotas);exit;
        // $this->run($rotas);
        
    }

    public function run(){
        $url_partes = parse_url($_SERVER['REQUEST_URI']);
        $route = explode('/', $url_partes['path']);
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if(!isset($this->route[$metodo][$route[1]])){
            $error = new $this->controller_error;
            $error->index();
            exit();
        }
        $this->param = array_slice($route, 2);

        $this->validarParametros($this->route[$metodo][$route[1]]['parametro']);

        $controller = explode('@', $this->route[$metodo][$route[1]]['controller']);

        // var_dump($controller);exit;

        $controller_path = $this->controller_path . $controller[0];
        $con_classe = new $controller_path;

        if(method_exists($con_classe, $controller[1])){
            call_user_func_array([$con_classe, $controller[1]], $this->param);
            exit();
        }
        $error = new $this->controller_error;
        $error->index();
                     
        
        exit();

   
    }

    private function validarParametros($validateParams) {
        $validate = array_map(function($param){
            if(is_numeric($param)) {
                return filter_var($param, FILTER_VALIDATE_INT);
            }
            return strip_tags($param);
        }, $this->param);
    
        if(count($validate) !== count($validateParams)) {
            $error = new $this->controller_error;
            $error->index();
            exit();
        }
        $this->param = $validate;
    }
}