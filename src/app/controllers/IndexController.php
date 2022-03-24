<?php
session_start();

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Manager;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->posts = Posts::find(['status!="pending"','order' => 'Date DESC']);
        $this->view->categories = Category::find();
    }
    public function tryAction()
    {
        $query = "select u.* , Comments.* from Comments join Users as u on Comments.user_id=u.user_id";
        $cars = $this->modelsManager->executeQuery($query);
        die(json_encode($cars));
    }
}
