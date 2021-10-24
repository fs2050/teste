<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsCreate cadastra é classe filha da classe AdmsConn, cadastra registros no banco de dados
 *
 * @author Celke
 */
class AdmsCreate extends AdmsConn
{
    /** @var string $table Recebe o nome da tabela*/
    private string $table;
    
    /** @var array $data Recebe os dados*/
    private array $data;
    
    /** @var string $result Recebe o resultado*/
    private string $result;
    
    /** @var object $insert Faz o cadastro*/
    private object $insert;
    
    /** @var string $query Recebe a Query a ser cadastrada no banco de dados*/
    private string $query;
    
    /** @var object $conn Recebe a conexão*/
    private object $conn;
    
    /**
     * Retorna o resultado do cadastro
     * @return string Retorna o resultado
     */
    function getResult(): string {
        return $this->result;
    }
    
    /**
     * Metodo para receber o nome da tabela e os dados que serão cadastrados no banco de dados
     * @param string $table
     * @param array $data
     * @return void
     */
    public function exeCreate($table, array $data): void {
        $this->table = (string) $table;
        $this->data = $data;
        $this->exeReplaceValues();
        $this->exeIntruction();
    }

    /**
     * Metodo privado, só pode ser chamado dentro da classe
     * Metodo configura a forma como os valores serão cadastrados na tabela do banco de dados
     * @return void
     */
    private function exeReplaceValues(): void {
        $coluns = implode(', ', array_keys($this->data));
        $values = ':' . implode(', :', array_keys($this->data));
        $this->query = "INSERT INTO {$this->table} ($coluns) VALUES ($values)";
    }

    /**
     * Metodo privado, só pode ser chamado dentro da classe
     * Metodo executa o cadastro no banco de dados
     * @return void
     */
    private function exeIntruction(): void {
        $this->connection();
        try {
            $this->insert->execute($this->data);
            $this->result = $this->conn->lastInsertId();
        } catch (Exception $ex) {
            $this->result = null;
        }
    }

    /** Metodo privado, só pode ser chamado dentro da classe
     * Metodo executa a conexão para que o cadastro no banco de dados seja feito
     */
    private function connection() {
        $this->conn = $this->connect();
        $this->insert = $this->conn->prepare($this->query);
    }

}
