<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use PDO;
/**
 * A classe AdmsConn faz a conexão com o banco de dados
 *
 * @author Celke
 */
class AdmsConn
{
    /** @var string $db Recebe o tipo de banco de dados*/
    private string $db = "mysql";
    
    /** @var string $host Recebe o Host */
    private string $host = HOST;
    
    /** @var string $user Recebe o nome de usuário*/
    private string $user = USER;
    
    /** @var string $pass Recebe a senha*/
    private string $pass = PASS;
    
    /** @var string $dbname Recebe o nome da tabela*/
    private string $dbname = DBNAME;
    
    /** @var int $db Recebe a porta do banco de dados*/
    private int $port = PORT;
    
    /** @var object $connect Recebe a conexão com o banco de dados*/
    private object $connect;
    
    /**
     * Metodo protegido, faz a conexão com o banco de dados
     * @return type Retorna a conexão
     */
    protected function connect() {
        try {
            $this->connect = new PDO($this->db . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname, $this->user, $this->pass);
            return $this->connect;
        } catch (Exception $ex) {
            die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
        }
    }
}
