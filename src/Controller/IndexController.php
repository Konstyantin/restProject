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
     * @var Post post entity class
     */
    private $post;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->post = new Post();
    }

    /**
     * Index action
     *
     * Main page which displayed posts
     *
     * @return bool
     */
    public function indexAction(int $id = null)
    {
        $result = $this->post->getListPost();

        $last = $this->post->getLastPost();

        return $this->render('index', [
            'result' => $result,
        ]);
    }

    /**
     * Change list action
     *
     * Change post list
     *
     * @param int $offset
     */
    public function changeListAction(int $offset)
    {
        $result = $this->post->getListPost($offset);

        $last = $this->post->getLastPost();

        echo json_encode(['list' => $result, 'count' => $this->post->getCount(), 'lastPost' => $last]);die();
    }

    /**
     * Update time action
     */
    public function updateTimeAction()
    {
        $list = $this->getPostParam('list') ?? null;

        if ($list) {

            $list = $this->post->getPostsByIdList($list);

            echo json_encode($list);
        }
    }

    /**
     * Order Action
     *
     * Make sort post list by send params
     */
    public function orderAction()
    {
        $column = $this->getPostParam('column') ?? null;
        $param = $this->getPostParam('param') ?? null;
        $count = $this->getPostParam('count') ?? null;

        $result = $this->post->orderPostByParams($column, $param, $count);

        echo json_encode($result);
    }

    /**
     * Get author by send token
     */
    public function authorAction()
    {
        $token = $this->getPostParam('token');

        $last = $this->post->getLastPost();

        $author = $this->post->getAuthorByToken($token);

        $count = $this->post->getPostCount();

        echo json_encode(['author' => $author, 'last' => $last, 'count' => $count]);
    }
}