<?php

/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:23
 */
namespace Acme\Controller;

use App\RequestMethod;
use App\PostCRUD;

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
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        $json = json_encode($post);

        if (!$json) {
            echo 'fail';
            return false;
        }

        header('Content-Type: application/json');

        echo $json;
    }

    public function postAction()
    {
        $crud = new PostCRUD();

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $title = $data->title;
        $author = $data->title;
        $content = $data->content;

        $crud->create($title, $content, $author);

        return 'create new post';
    }

    public function putAction(int $id)
    {
        return 'update post ' . $id;
    }

    public function deleteAction(int $id)
    {
        $crud = new PostCRUD();

        $crud->delete($id);
        return 'delete post' . $id;
    }
}