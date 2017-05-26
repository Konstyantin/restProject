<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.05.2017
 * Time: 15:07
 */
namespace Acme\Controller;

use Acme\Entity\Post;
use App\Controller;
use App\Pagination;


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
    public function indexAction(int $id = null)
    {
        $post = new Post();

        $result = $post->getListPost();

        return $this->render('index', [
            'result' => $result,
        ]);
    }

    public function changeListAction(int $offset)
    {
        $post = new Post();

        $result = $post->getListPost($offset);

        echo json_encode(['list' => $result, 'count' => $post->getCount()]);die();
    }
}