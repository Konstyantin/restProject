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
    private $post;

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

        echo json_encode(['list' => $result, 'count' => $this->post->getCount()]);die();
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

    public function orderAction()
    {
        $column = $this->getPostParam('column') ?? null;
        $param = $this->getPostParam('param') ?? null;
        $count = $this->getPostParam('count') ?? null;

        $result = $this->post->orderPostByParams($column, $param, $count);

        echo json_encode($result);
    }
}