<?php

session_start();
ob_start();

define('R4F5CC', true);

//Carregar o Composer
require './vendor/autoload.php';

//Atribuir apelido "Home" para rota da classe "Core\ConfigController"
use Core\ConfigController as Home;

//Instanciar a classe utilizando o apelido "Home".
$url = new Home();

//Instanciar o método
$url->carregar();