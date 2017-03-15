<?php

/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:23
 */
namespace Acme\Controller;

use App\RequestMethod;

class PostController
{
    public function listAction()
    {
        $request = new RequestMethod();

        $request->selectMethod($this);
    }

    public function viewAction(int $id)
    {
        $request = new RequestMethod();

        $request->selectMethod($this, $id);
    }

    public function getAction(int $id)
    {
        return 'get post ' . $id;
    }

    public function postAction()
    {
        return 'create new post';
    }

    public function putAction(int $id)
    {
        return 'update post ' . $id;
    }

    public function deleteAction(int $id)
    {
        return 'delete post' . $id;
    }
}