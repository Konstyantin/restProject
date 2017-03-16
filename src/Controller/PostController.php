<?php

/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:23
 */
namespace Acme\Controller;

use App\DataFormat\FactoryFormat;
use App\PostCRUD;
use App\RESTController;

class PostController extends RESTController
{
    public function getAction(int $id)
    {
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        $factory = new FactoryFormat();

        $data = $factory->encode($post);

        echo $data;
    }

    public function postAction()
    {
        $crud = new PostCRUD();

        $factory = new FactoryFormat();

        $type =  $_SERVER['CONTENT_TYPE'];

        $data = $factory->decode($type);

        $title = $data->title;
        $author = $data->author;
        $content = $data->content;

        $crud->create($title, $content, $author);

        return 'create new post';
    }

    public function putAction(int $id)
    {
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        $factory = new FactoryFormat();

        $type =  $_SERVER['CONTENT_TYPE'];

        $data = $factory->decode($type);

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
    }
}