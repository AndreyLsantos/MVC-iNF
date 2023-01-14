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
        $result = $query->fetch();
        if($result === false){
            throw new Exception("Registro com id: {$id} não foi encontrado");
        }
        return $result;
    }

    public function criar($campos, $condicao = [])
    {
        $param = [];
        $paramValue = [];
        $campos = array_diff_key($campos, array_flip($condicao));
        foreach($campos as $key => $values){
            $param[]= ":$key";
            $paramValue[":$key"] = $values;
        }    
        $campos = implode(',', array_keys($campos));
        $param = implode(',', $param);  
        $sql = "INSERT INTO $this->tabela ($campos) VALUES ($param) ";
        $query = $this->pdo->prepare($sql);
        $exec = $query->execute($paramValue);
        return $exec ? $this->pdo->lastInsertId() : false;
    }

    public function atualizar($campos, $condicao = [])
    {
        $param = [];
        $paramValues = [];
        $campos = array_diff_key($campos, array_flip($condicao));
        foreach($campos as $key => $values){
            $param[]= ":$key";
            $paramValue[":$key"] = $values;
        }
        $sql = "UPDATE " . $this->tabela . " SET " . implode(', ', $param) . " WHERE id = :id LIMIT 1";
        $query = $this->pdo->prepare($sql);
        $query->execute($paramValues);
    }

    public function deletar($id){
        $sql = "DELETE FROM " . $this->tabela . " WHERE id = :id LIMIT 1 ";
        $query = $this->pdo->prepare($sql);
        return $query->execute([':id'=>$id]); 
    }
}