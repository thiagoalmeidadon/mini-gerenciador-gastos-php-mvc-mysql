<?php
namespace Controller;

use Authenticator\Authenticator;
use DB\Connection;
use Entity\User;
use Session\Flash;
use  View\View;

class AuthController
{
    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            var_dump($_POST);

            $user = new User(Connection::getInstance());
            $authenticator = new Authenticator($user);

            if(!$authenticator->login($_POST))
            {
                Flash::add("warning", "Dados incorretos!");
                return header("Location: " . HOME . '/auth/login');
            }

            Flash::add("success","Logado com sucesso!");
            return header("Location: " . HOME . '/myexpenses');

        }
        $view = new View('auth/index.phtml');
        return $view->render();
    }

    public function logout()
    {
        $auth = (new Authenticator())->logout();
        Flash::add("success","Até mais!");
        return header("Location: " . HOME . '/auth/login');
    }
}