<?php
namespace Controller;

use Authenticator\CheckUserLogged;
use DB\Connection;
use Entity\Category;
use Entity\Expense;
use Entity\User;
use Session\Session;
use View\View;

class MyExpensesController
{
    use CheckUserLogged;


    public function __construct()
    {
        if(!$this->check())
        {
            die("Usuario nao logado");
        }
    }


    public function index()
    {

        //var_dump("chegou aqui ");
        $view = new View('expenses/index.phtml');

        $view->expenses = (new Expense(Connection::getInstance()))
          ->where(['users_id' => Session::get('user')['id'] ]);

        //$view->expenses = (new Expense(Connection::getInstance()))->findAll();

        return $view->render();
    }

    public function new()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $connection = Connection::getInstance();
         /*  print_r([
                'value' =>  $_POST['value']  , 'categories_id' => $_POST['categories_id'],
                'users_id' =>  $_POST['users_id']  , 'description' => $_POST['description']

            ]);*/

        if($method == 'POST')
        {
            $data = $_POST;

            $data['users_id'] = Session::get('user')['id'];

            $expense = new Expense($connection);
            $expense->insert($data);
            return header('Location: ' . HOME . '/myexpenses');
        }

        $view = new View('expenses/new.phtml');

        $view->categories = (new Category($connection))->findAll();
        $view->users = (new User($connection))->findAll();



        return $view->render();
    }


    public function edit($id)
    {
        $view = new View('expenses/edit.phtml');

        $method = $_SERVER['REQUEST_METHOD'];
        $connection = Connection::getInstance();

        if($method == 'POST')
        {
            $data = $_POST;
            $data['id'] = $id;

            $expense = new Expense($connection);
            $expense->update($data);

            return header('Location: ' . HOME . '/myexpenses');
        }

        $view->categories = (new Category($connection))->findAll();
        $view->users = (new User($connection))->findAll();
        $view->expense = (new Expense($connection))->find($id);

        return $view->render();

    }

    public function remove($id)
    {
        $expense = new Expense(Connection::getInstance());
        $expense->delete($id);

        return header('Location: ' . HOME . '/myexpenses');
    }


}