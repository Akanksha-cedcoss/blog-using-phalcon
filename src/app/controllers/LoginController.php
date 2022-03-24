<?php
session_start();

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->request->getPost()) {
            $email =  $this->request->getPost('typeEmail');
            $password =  $this->request->getPost('typePassword');
            $user = Users::findFirst('email = "' . $email . '" and password="' . $password . '"');
            if ($user) {
                // die('this');
                $_SESSION['user'] = [
                    'id' => $user->user_id,
                    'name' => $user->name,
                    'role' => $user->role
                ];
                header("location:../index");
            } else {
                // return 'this';
                $this->response->setContent("Email or password is incorrect .");
            }
        }
    }
    public function logoutAction()
    {
        unset($_SESSION['user']);
        header("location:../index");
    }
}
