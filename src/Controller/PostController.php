<?php

/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:23
 */
namespace Acme\Controller;

use App\DataFormat\FactoryFormat;
use Acme\Entity\Post;
use App\RESTController;
use App\Request;
use App\StatusRequest;
use Swagger\Annotations as SWG;

/**
 * Class PostController
 *
 * @package Acme\Controller
 */
class PostController extends RESTController
{
    /**
     * @SWG\Get(
     *     path="/post/{id}",
     *     description="Return a post on a single ID, if user have access to the post",
     *     operationId="getAction",
     *     produces={
     *          "application/json",
     *          "application/xml",
     *     },
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of post to fetch",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
     *     @SWG\Parameter(
     *          name="X-API_KEY",
     *          in="header",
     *          description="Authentication Key",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Get post success"
     *     ),
     *     @SWG\Response(
     *          response=403,
     *          description="When user not authentication"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="When post by ID not found"
     *     ),
     *     @SWG\Response(
     *          response="default",
     *          description="unexpected error",
     *          @SWG\Schema(
     *              ref="#/definitions/ErrorModel"
     *          )
     *     )
     * )
     *
     * @param int $id
     * @return int
     */
    public function getAction(int $id)
    {
        $crud = new Post();

        $post = $crud->getOne($id);

        if ($post) {

            $factory = new FactoryFormat();
            $data = $factory->encode($post); // second argument set type result JSON|XML

            echo $data;

            Request::setStatus(StatusRequest::POST_SUCCESS); // status 200

            die();
        }

        return Request::setStatus(StatusRequest::POST_NOT_FOUND);   // status 404
    }


    /**
     * Create new Post
     *
     * @SWG\Post(
     *     path="/post",
     *     description="Create new post use send post data",
     *     operationId="postAction",
     *     produces={
     *          "application/json",
     *          "application/xml",
     *     },
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Post data for new post",
     *          required=true,
     *          @SWG\Schema(
     *              ref="#/definitions/Post"
     *          ),
     *     ),
     *     @SWG\Parameter(
     *          name="X-API_KEY",
     *          in="header",
     *          description="Authentication Key",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="When new post created success"
     *     ),
     *     @SWG\Response(
     *          response=403,
     *          description="When user not authentication"
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="When post data is empty"
     *     ),
     *     @SWG\Response(
     *          response="default",
     *          description="unexpected error",
     *          @SWG\Schema(
     *              ref="#/definitions/ErrorModel"
     *          )
     *     )
     * )
     *
     * @return int
     */
    public function postAction()
    {
        $crud = new Post();

        $factory = new FactoryFormat();

        $type = Request::getContentType();

        $data = $factory->decode($type); // set type JSON|XML

        $title = $data->title ?? null;
        $content = $data->content ?? null;
        $author = Request::getAuthorByToken(); // get user id from send token

        if ($title && $author && $content) {
            $result = $crud->create($title, $content, $author);

            if ($result) {
                return Request::setStatus(StatusRequest::POST_CREATED); // status 201
            }
        }

        return Request::setStatus(StatusRequest::POST_BAD_REQUEST);     // status 400
    }

    /**
     * Update post
     *
     * @SWG\Put(
     *     path="/post/{id}",
     *     description="Update select post by id",
     *     operationId="putAction",
     *     produces={
     *          "application/json",
     *          "application/xml",
     *     },
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of post to fetch",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Post data for update or create new post",
     *          required=true,
     *          @SWG\Schema(
     *              ref="#/definitions/Post"
     *          ),
     *     ),
     *     @SWG\Parameter(
     *          name="X-API_KEY",
     *          in="header",
     *          description="Authentication Key",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="When new post created success"
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="When post updated success"
     *     ),
     *     @SWG\Response(
     *          response=403,
     *          description="When user not authentication"
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="When post data is empty"
     *     ),
     *     @SWG\Response(
     *          response="default",
     *          description="unexpected error",
     *          @SWG\Schema(
     *              ref="#/definitions/ErrorModel"
     *          )
     *     )
     * )
     *
     * @param int $id
     * @return int
     */
    public function putAction(int $id)
    {
        $crud = new Post();

        $factory = new FactoryFormat();

        $post = $crud->getOne($id);

        // get data type
        // default JSON
        $type = Request::getContentType();

        $data = $factory->decode($type);

        // check exists methods

        $title = $data->title ?? null;
        $content = $data->content ?? null;
        $author = Request::getAuthorByToken(); // get user id from send token

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
     * @SWG\Delete(
     *     path="/post/{id}",
     *     description="Delete post by select ID",
     *     operationId="deleteAction",
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of post to fetch",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
     *     @SWG\Parameter(
     *          name="X-API_KEY",
     *          in="header",
     *          description="Authentication Key",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Delete post success"
     *     ),
     *     @SWG\Response(
     *          response=403,
     *          description="When user not authentication"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="When post by ID not found"
     *     ),
     * )
     *
     * @param int $id
     * @return int
     */
    public function deleteAction(int $id)
    {
        $crud = new Post();

        $post = $crud->getOne($id);

        if ($post) {
            $crud->delete($id);
            return Request::setStatus(StatusRequest::POST_SUCCESS);
        }

        return Request::setStatus(StatusRequest::POST_NOT_FOUND);
    }
}