<?php

class AuthHelper {

    public function __construct() {}

    public function login($user) {
        // INICIO LA SESSION Y LOGUEO AL USUARIO
        session_start();
        $_SESSION['USER_ID'] = $user->id;// arreglo para guardar datos
        $_SESSION['USERNAME'] = $user->username;
    }
    public function logout() {
        session_start();
        session_destroy();
    }
    public function checkLoggedIn() {
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . LOGIN);
            die();
        }       
    }
    public function getLoggedUserName() {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();
        return $_SESSION['USER_ID'];
    }
}
