<?php

namespace InfluenceDigital\Core;

require_once  APP . 'config/config.php';

use Exception;
use PDO;

/**
 * 
 * Class model pra gerenciar o banco de dados.
 * 
 */

class Model
{
    protected $pdo;
    protected $tabela;

    public function __construct($tabela)
    {
        $this->tabela = $tabela;
        try{    
            $this->pdo = new PDO(DB . ':host=' . HOST . ';dbname=' . DBNAME , USER , PASS );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die('Erro: Por favor tente novamente ou entre em contato com algum administrador.');
        }
    }

    public function todos($condicao = [])
    {
        $where = '';
        $params = [];

        if(!empty($condicao)){
            $where .= 'WHERE ' . implode(' AND ', array_map( function($parametro){
                return $parametro[0] . ' ' . $parametro[1] . ' ? '; 
            }, $condicao));
            $params = array_column($condicao, 2);
        }
        $sql = "SELECT * FROM " . $this->tabela . " WHERE 1=1 " . $where . " ORDER BY id DESC, id";
        $query = $this->pdo->prepare($sql);

        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function procurar($id)
    {
        $sql = "SELECT * FROM " . $this->tabela . " WHERE id = :id LIMIT 1 ";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id'=>$id]);
        return $query->fetch();
    }

    public function criar($campos, $condicao = [])
    {
        // $param pra consulta no sql no formato $key = :$key
        $param = [];

        // $paramValue parametro pro $query->execute($paramValue) no formato ([':param' => $param] )
        $paramValue = [];
        foreach($campos as $key => $values){
            // se a chave tiver no array condicao
            if(!in_array($key, $condicao)){
                $param[]= $key . '= :' . $key;
                $paramValue[':' . $key] = $values;
            }
        }        
        $sql = "INSERT INTO  " . $this->tabela . ' '.  implode(', ', $param);
        $query = $this->pdo->prepare($sql);
        $exec = $query->execute($paramValue);
        if($exec){
           $return = $this->pdo->lastInsertId();
        }else{
            $return = false;
        }
        return $return;
    }

    public function atualizar($campos, $condicao = [])
    {
        $param = [];
        $paramValues = [];
        foreach($campos as $key => $values){
            if(!in_array($key, $condicao)){
                $param[] = $key . " = :" . $key;
                $paramValues[':' . $key ] = $values ;
            }
        }
        $sql = "UPDATE " . $this->tabela . " SET " . implode(', ', $param) . " WHERE id = :id LIMIT 1";
        $query = $this->pdo->prepare($sql);
        $query->execute($paramValues);
    }

    public function deletar($id){
        try{
            $sql = "DELETE * FROM " . $this->tabela . " WHERE id = :id LIMIT 1 ";
            $query = $this->pdo->prepare($sql);
            $query->execute([':id'=>$id]);
        }catch(Exception $e){
            die('Algo deu errado, contate um administrador ou retorne mais tarde!');
        }
 
    }
}