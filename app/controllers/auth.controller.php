<?php
require_once './app/views/auth.view.php';
require_once './app/models/user.model.php';

class AuthController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showFormLogin()
    {
        $this->view->showFormLogin();
    }

    public function validateUser()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            //obtengo el usuario de la base de datos
            $user = $this->model->getUserByEmail($email);

            //password_verify controla que conincidan las contrase;as
            if ($user && password_verify($password, $user->password)) {
                //iniciar sesion
                session_start();
                $_SESSION['USER_ID'] = $user->id;
                $_SESSION['USER_EMAIL'] = $user->email;
                $_SESSION['IS_LOGGED'] = true;
                header("Location: " . BASE_URL);
            } else {
                // si los datos son incorrectos muestro el form con un error
                $this->view->showFormLogin("El usuario o la contraseña no existe.");
            }
        }
    }
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL);
    }
    function checkLoggedIn(){
        session_start();
        if(empty($_SESSION['USER_ID'])){
            header("Location: " . BASE_URL . "login");
            die();
        }
    }
}
