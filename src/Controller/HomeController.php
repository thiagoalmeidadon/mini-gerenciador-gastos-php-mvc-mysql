<?php
namespace Controller;

use DB\Connection;
use Entity\Product;
use View\View;

class HomeController
{
    public function index()
    {
        //$pdo =  Connection::getInstance();

        $view = new View('site/index.phtml');

       return $view->render();
    }
}
