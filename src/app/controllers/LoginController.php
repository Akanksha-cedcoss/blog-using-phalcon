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
                $this->session->set('name', $user->name);
                $this->session->set('role', $user->role);
                $this->session->set('id', $user->user_id);
                header("location:../index");
            } else {
                // return 'this';
                $this->response->setContent("Email or password is incorrect .");
            }
        }
    }
    public function logoutAction()
    {
        $this->session->destroy();
        header("location:../index");
    }
}
