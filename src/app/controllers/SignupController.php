<?php
session_start();

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{

    public function indexAction()
    {
        if ($this->request->getPost()) {
            $email = $this->request->getPost('email');
            $user = new Users();
            try {
                $user->assign(
                    $this->request->getPost(),
                    [
                        'name',
                        'email',
                        'password'
                    ]
                );
                $user->save();
                if ($user) {
                    $_SESSION['user'] = [
                        'id' => $user->user_id,
                        'name' => $user->name,
                        'role' => $user->role
                    ];
                    header("location:../index");
                } else {
                    $this->response->setContent($user->getMessages());
                }
            } catch (Exception $e) {
                $this->response->setContent("E-mail is already registered with us.");
            }
        }
    }
}
