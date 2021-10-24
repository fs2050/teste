<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use PDO;

/**
 * A classe AdmsRead é classe filha da classe AdmsConn, faz a leitura dos registros no banco de dados
 *
 * @author Celke
 */
class AdmsRead extends AdmsConn
{
    /** @var string $select Recebe o select*/
    private string $select;
    
    /** @var array $values Recebe os valores que serão pesquisados*/
    private array $values = [];
    
    /** @var array $result Recebe o resultado do que foi pesquisado*/
    private array $result = [];
    
    /** @var object $query Recebe a query que será pesquisada no banco de dados*/
    private object $query;
    
    /** @var object $conn Recebe a conexão com o banco de dados*/
    private object $conn;

    /**
     * Retorna o resultado
     * @return array Recebe o resultado
     */
    function getResult(): array {
        return $this->result;
    }

    /**
     * Metodo recebe a tabela, termos e a parseString
     * @param type $tabela Recebe a tabela 
     * @param type $termos Recebe os termos
     * @param type $parseString Recebe a parseString
     */
    public function exeRead($tabela, $termos = null, $parseString = null) {
        if (!empty($parseString)) {
            parse_str($parseString, $this->values);
        }
        $this->select = "SELECT * FROM {$tabela} {$termos}";
        $this->exeIntruction();
    }
    
    /**
     * Metodo faz a busca completa no banco de dados
     * @param object $query Recebe a query que faz a busca no banco de dados
     * @param type $parseString Recebe a parseString
     */
    public function fullRead($query, $parseString = null) {
        $this->select = $query;
        if (!empty($parseString)) {
            parse_str($parseString, $this->values);
        }
        $this->exeIntruction();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo executa a instrução
     */
    private function exeIntruction() {
        $this->connection();
        try {
            $this->exeParameter();
            $this->query->execute();
            $this->result = $this->query->fetchAll();
        } catch (Exception $ex) {
            $this->result = null;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz a conexão para que a pesquisa no banco de dados seja feita
     */
    private function connection() {
        $this->conn = $this->connect();
        $this->query = $this->conn->prepare($this->select);
        $this->query->setFetchMode(PDO::FETCH_ASSOC);
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz a execução dos parametros da pesquisa Limit e o Offset
     */
    private function exeParameter() {
        if ($this->values) {
            foreach ($this->values as $link => $value) {
                if ($link == 'limit' || $link == 'offset') {
                    $value = (int) $value;
                }
                $this->query->bindValue(":{$link}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        }
    }

}
