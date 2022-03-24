<?php
session_start();

use Phalcon\Mvc\Controller;


class BlogController extends Controller
{
    public function indexAction($post_id)
    {
        // $this->view->blog = Posts::findFirst($post_id);
        $this->view->blog = $this->modelsManager->executeQuery("select Users.*,Posts.* from Posts join Users on Posts.user_id = Users.user_id where post_id =".$post_id."");
        $query = "select Users.* , Comments.* from Comments join Users on Comments.user_id=Users.user_id where post_id = ".$post_id."";
        $this->view->comments = $this->modelsManager->executeQuery($query);
        // $this->view->comments = Comments::find('post_id = ' . $post_id . '');
    }
    public function postCommentAction($post_id)
    {
        if (!isset($this->session->id)) {
            header("location:http://localhost:8080/login");
        }
        $comment = new Comments();
        $comment->user_id = $this->session->id;
        $comment->comment = $this->request->getPost('comment');
        $comment->post_id = $post_id;
        $comment->save();
        header("location:http://localhost:8080/blog/index/".$post_id);
    }
    public function categoryAction($category_id)
    {
        $this->view->blogs = Posts::find('category_id = ' . $category_id . ' and status != "pending"');
    }
}