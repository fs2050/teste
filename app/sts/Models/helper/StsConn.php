<?php

namespace App\sts\Models\helper;

use PDO;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
/**
 * Conexão com o banco de dados
 *
 * @author Celke
 */
abstract class StsConn
{

    /** @var string $host Recebe o host da constante HOST */
    private string $host = HOST;
    /** @var string $user Recebe o usuário da constante USER */
    private string $user = USER;
    /** @var string $pass Recebe a senha da constante PASS */
    private string $pass = PASS;
    /** @var string $dbName Recebe a base de dados da constante DBNAME */
    private string $dbName = DBNAME;
    /** @var int $port Recebe a porta da constante PORT */
    private int $port = PORT;
    /** @var object $connect Recebe a conexão com o banco de dados */
    private object $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * @return object retorna a conexão com o banco de dados
     */
    protected function connect(): object {
        try {
            $this->connect = new PDO("mysql:host={$this->host};port={$this->port};dbname=" . $this->dbName, $this->user, $this->pass );
            return $this->connect;
        } catch (Exception $ex) {
            die('Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ' . EMAILADM . '<br>');
        }
    }

}
