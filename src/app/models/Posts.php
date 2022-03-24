<?php

use Phalcon\Mvc\Model;

Class Posts extends Model{
    public $post_title;
    public $post_img;
    public $thumbnail;
    public $user_id;
    public $description;
    public $category_id;
}