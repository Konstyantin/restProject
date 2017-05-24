<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.05.2017
 * Time: 15:07
 */
namespace Acme\Controller;

use App\Controller;
use Acme\Entity\Post;


/**
 * Class IndexController
 * @package Acme\Controller
 */
class IndexController extends Controller
{
    /**
     * Index action
     *
     * Main page which displayed posts
     *
     * @return bool
     */
    public function indexAction()
    {
        $post = new Post();

        $postList = $post->getListOrderBy('created_at');

        return $this->render('index', $postList);
    }
}