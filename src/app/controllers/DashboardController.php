<?php
session_start();

use Phalcon\Mvc\Controller;


class DashboardController extends Controller
{
    public function indexAction()
    {
    }
    public function userDashboardAction()
    {
        $_SESSION['user']['role']=='admin'?
        $this->view->users = Users::find():
        $this->view->user = Users::findFirst($_SESSION['user']['id']);
    }
    public function blogDashboardAction()
    {
        $this->view->posts = $_SESSION['user']['role']=='admin'?
        Posts::find(['order'=>'Date DESC'])
        :Posts::find(["user_id = ".$_SESSION['user']['id']."",'order' => 'Date DESC',]);
    }
    public function createBlogAction()
    {
        $this->view->category = Category::find();
    }
    public function editUserAction($user_id)
    {
        $user = Users::findFirst("user_id=" . $user_id . "");
        $status = $user->role == 'reader' ? 'writer' : 'reader';
        $user->role = $status;
        $user->save();
        header("location:http://localhost:8080/dashboard/userDashboard");
    }
    public function deleteUserAction($user_id)
    {
        Users::findFirst("user_id=" . $user_id . "")->delete();
        header("location:http://localhost:8080/dashboard/userDashboard");
    }
    public function editPostAction($post_id)
    {
        $post = Posts::findFirst("post_id=" . $post_id . "");
        $status = $post->status == 'pending' ? 'published' : 'pending';
        $post->status = $status;
        $post->save();
        // die(print_r($post->status));
        header("location:http://localhost:8080/dashboard/blogDashboard");
    }
    public function blogUploadAction()
    {
        $post = new Posts();
        $post->post_title = $this->request->getPost('title');
        $post->post_img = $this->request->getPost('fileToUpload');
        $post->thumbnail = $this->request->getPost('thumbnail');
        $post->user_id = $_SESSION['user']['id'];
        $post->description = $this->request->getPost('description');
        $post->category_id = (int)$this->request->getPost('category');
        $success = $post->save();
        if ($success) {
            header("location:http://localhost:8080/dashboard/blogDashboard");
        } else {
            die(print_r($post->getMessages()));
        }
    }
}
