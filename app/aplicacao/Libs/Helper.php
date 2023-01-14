<?php

namespace InfluenceDigital\Libs;

use Exception;

class Helper
{
    static public function separar_url()
    {
        if(!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){
            $url = trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    static public function view($view, $response = [])
    {
        if(!$view) {
            $view = 'error/index';
        }
        require APP . 'Views/' . $view . '.php';
    }

    static public function redirecionar($view) {
        if (!file_exists(APP . "Views/$view.php")) {
            throw new Exception("Página inválida!.");
        }
        include(APP . "Views/$view.php");
        exit;
    }

    static public function loadView($view, $data = []){
        extract($data);
        require_once APP . 'Views/'. $view .'.php';
    }

    static public function loadPublic($css = [], $js = []){
        if(!empty($css) AND is_array($css)){
            foreach ($css as $file) {
                $caminho = 'public/css/' . $file;
                if(file_exists($caminho)) {
                    echo '<link href="' . $caminho . '" rel="stylesheet">';
                }else{
                    trigger_error("O arquivo css '{$file}' não foi encontrado", E_USER_WARNING);
                }
            }
        }else{
            return false;
        } 
        
        if(!empty($js) AND is_array($js)){
            foreach ($js as $file) {
                $caminho = 'public/js/' . $file;
                if (file_exists($caminho)) {
                    echo '<script src="' . $caminho . '"></script>';
                }else{
                    trigger_error("O arquivo js '{$file}' não foi encontrado", E_USER_WARNING);
                }
            }
        }else{
            return false;
        }
    }
}