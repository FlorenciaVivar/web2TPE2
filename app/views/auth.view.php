<?php
require_once './libs/smarty-4.2.1/libs/Smarty.class.php';

class AuthView {
    private $smarty;

    public function __construct() {
        $this->smarty = new Smarty(); // inicializo Smarty
    }

    function showFormLogin($error=null) {
        //$error=null-> puedo o no pasarlo al mensaje de error contrase;a incorrects
        $this->smarty->assign("error", $error);
        $this->smarty->display('formUser.tpl');
    }
}
