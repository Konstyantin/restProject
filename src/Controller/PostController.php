<?php

/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:23
 */
namespace Acme\Controller;

use App\PostCRUD;
use App\RESTController;

class PostController extends RESTController
{
    public function getAction(int $id)
    {
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        $json = json_encode($post);

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
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $title = $data->title;
        $content = $data->content;
        $author = $data->author;

        if ($post) {
            $crud->updatePost($id, $title, $content);
        } else {
            $crud->create($title, $content, $author);
        }
    }

    public function deleteAction(int $id)
    {
        $crud = new PostCRUD();

        $crud->delete($id);
        return 'delete post' . $id;
    }
}