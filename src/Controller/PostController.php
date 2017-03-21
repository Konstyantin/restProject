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
use App\Request;
use App\StatusRequest;

/**
 * Class PostController
 * @package Acme\Controller
 */
class PostController extends RESTController
{
    /**
     * Get one Post by $id
     *
     * @param int $id
     *
     * @ApiDoc(
     *     statusCodes={
     *          200 = "Return when success",
     *          404 = "Return when not found"
     *     }
     * )
     *
     * @return mixed
     */
    public function getAction(int $id)
    {
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        if ($post) {

            $factory = new FactoryFormat();
            $data = $factory->encode($post);

            echo $data;

            return Request::setStatus(StatusRequest::POST_SUCCESS);
        }

        return Request::setStatus(StatusRequest::POST_NOT_FOUND);
    }

    /**
     * Create new Post
     *
     * @ApiDoc(
     *     statusCodes={
     *          201 = "Return when success",
     *          400 = "Return when data error"
     *     }
     * )
     *
     * @return string
     */
    public function postAction()
    {
        $crud = new PostCRUD();

        $factory = new FactoryFormat();

        $type = Request::getContentType();

        $data = $factory->decode($type);

        $title = $data->title ?? null;
        $content = $data->content ?? null;
        $author = Request::getAuthorByToken();

        if ($title && $author && $content) {
            $result = $crud->create($title, $content, $author);

            if ($result) {
                return Request::setStatus(StatusRequest::POST_CREATED);
            }
        }

        return Request::setStatus(StatusRequest::POST_BAD_REQUEST);
    }

    /**
     * Update post
     *
     * @ApiDoc(
     *     statusCodes={
     *          204 = "Return when success",
     *          201 = "Return when new Post"
     *          400 = "Return when data error"
     *     }
     * )
     *
     * @param int $id
     * @return int
     */
    public function putAction(int $id)
    {
        $crud = new PostCRUD();

        $factory = new FactoryFormat();

        $post = $crud->getOne($id);

        // get data type
        // default JSON
        $type = Request::getContentType();

        $data = $factory->decode($type);

        // check exists methods

        $title = $data->title ?? null;
        $content = $data->content ?? null;
        $author = Request::getAuthorByToken();

        // check passed availability params
        // requirements for update exists post
        if ($post && $title && $content) {

            $crud->updatePost($id, $title, $content);
            return Request::setStatus(StatusRequest::POST_NO_CONTENT); // status 204

        } elseif ($title && $content) { // requirements for create new post

            $crud->create($title, $content, $author);
            return Request::setStatus(StatusRequest::POST_CREATED); // status 201
        }

        // if param is false
        return Request::setStatus(StatusRequest::POST_BAD_REQUEST); // status 400
    }

    /**
     * Delete post
     *
     * @ApiDoc(
     *     statusCodes={
     *          204 = "Return when success",
     *          404 = "Return when data error"
     *     }
     * )
     *
     * @param int $id
     * @return int
     */
    public function deleteAction(int $id)
    {
        $crud = new PostCRUD();

        $post = $crud->getOne($id);

        if ($post) {
            $crud->delete($id);
            return Request::setStatus(StatusRequest::POST_NO_CONTENT);
        }

        return Request::setStatus(StatusRequest::POST_NOT_FOUND);
    }
}