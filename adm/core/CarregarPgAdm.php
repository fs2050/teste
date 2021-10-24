<?php

namespace Core;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of CarregarPgAdm
 *
 * @author Celke
 */
class CarregarPgAdm
{

    private string $urlController;
    private string $urlMetodo;
    private string $urlParamentro;
    private string $classe;
    private array $pgPublica;
    private array $pgRestrita;


    /**
     * 
     * @param string $urlController Recebe da URL o nome da controller
     * @param string $urlMetodo Recebe da URL o método
     * @param string $urlParamentro Recebe da URL o parâmetro
     */
    public function carregarPg($urlController = null, $urlMetodo = null, $urlParamentro = null):void {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParamentro = $urlParamentro;

        $this->pgPublica();
        
        if (class_exists($this->classe)) {
            $this->carregarMetodo();
        } else {
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParamentro = "";
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->carregarMetodo();
        }        
    }
    
    private function carregarMetodo() {
        $classCarregar = new $this->classe();
        if(method_exists($classCarregar, $this->urlMetodo)){
            $classCarregar->{$this->urlMetodo}($this->urlParamentro);
        }else{
            die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
        }        
    }
    
    private function pgPublica() {
        $this->pgPublica = ["Login", "Sair", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"];
        
        if(in_array($this->urlController, $this->pgPublica)){
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        }else{
            $this->pgRestrita();
        }
    }
    
    private function pgRestrita() {
        $this->pgRestrita = ["Dashboard", "ListUsers", "ViewUsers", "AddUsers", "EditUsers", "EditUsersPassword", "EditUsersImage", "DeleteUsers", "ViewPerfil", "EditPerfil", "EditPerfilPassword", "EditPerfilImage", "ListSitsUsers", "AddSitsUsers", "EditSitsUsers", "ViewSitsUsers", "DeleteSitsUsers", "ListColors", "ViewColors", "AddColors", "EditColors", "DeleteColors", "ListConfEmails", "AddConfEmails", "ViewConfEmails", "EditConfEmails", "EditConfEmailsPassword", "DeleteConfEmails", "ListAccessLevels", "ViewAccessLevels", "AddAccessLevels", "EditAccessLevels", "DeleteAccessLevels", "ViewLevelsForms", "EditLevelsForms", "OrderAccessLevels", "ListTypesPages", "ViewTypesPages", "AddTypesPages", "EditTypesPages", "DeleteTypesPages", "OrderTypesPages", "ListSitsPages", "ViewSitsPages", "AddSitsPages", "EditSitsPages", "DeleteSitsPages", "ListGroupsPages", "ViewGroupsPages", "AddGroupsPages", "EditGroupsPages", "DeleteGroupsPages", "OrderGroupsPages", "ListPages", "ViewPages", "AddPages", "EditPages", "DeletePages", "ListPermission", "SyncPagesLevels", "EditPermission"];
        if(in_array($this->urlController, $this->pgRestrita)){
            $this->verificarLogin();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrada!</div>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }
    
    private function verificarLogin() {
        if(isset($_SESSION['user_id']) AND isset($_SESSION['user_name']) AND isset($_SESSION['user_email']) AND isset($_SESSION['adms_access_level_id']) AND isset($_SESSION['order_levels'])){
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Para acessar a página realize o login!</div>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    private function slugController($slugController) {
        //Converter para minusculo
        $this->slugController = strtolower($slugController);
        //Converter o traço para espaço em braco
        $this->slugController = str_replace("-", " ", $this->slugController);
        //Converter a primeira letra de cada palavra para maiusculo
        $this->slugController = ucwords($this->slugController);
        //Retirar o espaço em braco
        $this->slugController = str_replace(" ", "", $this->slugController);

        return $this->slugController;
    }

    private function slugMetodo($slugMetodo) {
        $this->slugMetodo = $this->slugController($slugMetodo);
        //Converter para minusculo a primeira letra
        $this->slugMetodo = lcfirst($this->slugMetodo);

        return $this->slugMetodo;
    }  

}
