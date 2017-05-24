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
        // get active pagination step
        $active = $id ?? 1;

        $id = (!$id) ? null : $id - 1;

        $pagination = new Pagination();

        $pagination->setPageRange(10);

        $result = $pagination->getPaginationData(10, null, $id);

        $steps = $pagination->getSteps();

        return $this->render('index', [
            'result' => $result,
            'steps' => $steps,
            'active' => $active
        ]);
    }
}