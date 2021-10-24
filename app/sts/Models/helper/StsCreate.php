<?php

namespace App\sts\Models\helper;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Classe gernérica para cadastrar registro no banco de dados
 *
 * @author Celke
 */

class StsCreate extends StsConn
{

    /** @var string $table Recebe o nome da tabela */
    private string $table;
    /** @var array $data Recebe os dados que devem ser inseridos no BD */
    private array $data;
    /** @var string $result Retorna o status do cadastro */
    private string $result;
    /** @var object $insert Recebe a QUERY preparada */
    private object $insert;
    /** @var string $query Recebe a QUERY */
    private string $query;
    /** @var object $conn Recebe a conexão com o BD */
    private object $conn;

    /**
     * Retornar o status do cadastro, retorna o último id quando cadatrar com sucesso e null quando houver erro
     * @return string Retorna o último id inserido
     */
    function getResult(): string {
        return $this->result;
    }

    /**
     * Cadatrar no banco de dados
     * 
     * @param string $table Recebe o nome da tabela
     * @param array $data Recebe os dados do formulário
     * @return void
     */
    public function exeCreate($table, array $data): void {
        $this->table = (string) $table;
        $this->data = $data;
        $this->exeReplaceValues();
        $this->exeIntruction();
    }

    /**
     * Cria a QUERY e os links da QUERY
     * 
     * @return void
     */
    private function exeReplaceValues(): void {
        $coluns = implode(', ', array_keys($this->data));
        $values = ':' . implode(', :', array_keys($this->data));
        $this->query = "INSERT INTO {$this->table} ({$coluns}) VALUES ({$values})";
    }

    /**
     * Executa a QUERY. 
     * Quando executa a query com sucesso retorna o último id inserido, senão retorna null.
     * 
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

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void {
        $this->conn = $this->connect();
        $this->insert = $this->conn->prepare($this->query);
    }

}
