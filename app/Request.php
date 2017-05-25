<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 13:22
 */
namespace App;

use App\Access\APIToken;

/**
 * Class Request
 * @package App
 */
class Request
{
    /**
     * Get response status
     *
     * @return int
     */
    public static function getStatus()
    {
        return (string)http_response_code();
    }

    /**
     * Set response status
     *
     * @param int $status
     * @return int
     */
    public static function setStatus(int $status)
    {
        return http_response_code($status);
    }

    /**
     * Get Content-Type header property
     *
     * @return mixed
     */
    public static function getContentType()
    {
        return $_SERVER['CONTENT_TYPE'];
    }

    /**
     * Set Content-Type
     *
     * @param string $type
     */
    public static function setContentType(string $type)
    {
        return header('Content-Type: ' . $type);
    }

    /**
     * Check exists X-AUTH_TOKEN in response header
     *
     * @return bool
     */
    public static function checkHeaderToken()
    {
        $result = getallheaders();

        return (isset($result['X-AUTH_TOKEN'])) ? true : false;
    }

    /**
     * Return X-AUTH_TOKEN if token exists
     *
     * @return array|false
     */
    public static function getAuthToken()
    {
        if (self::checkHeaderToken()) {
            $headerResponse = getallheaders();
            return $headerResponse['X-AUTH_TOKEN'];
        }

        return false;
    }

    /**
     * Get Author by Token
     *
     * Get id Author by send token
     *
     * @return mixed
     */
    public static function getAuthorByToken()
    {
        $apiToken = new APIToken();

        return $apiToken->getTokenAuthor(self::getAuthToken());
    }

    /**
     * Get request method
     *
     * @return mixed
     */
    protected function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get post param
     *
     * Get post param by select param key
     *
     * @param string $param
     * @return mixed
     */
    public function getPostParam(string $param)
    {
        return $_POST[$param] ?? null;
    }

    /**
     * Get post param
     *
     * Get post param array
     *
     * @return mixed
     */
    protected function getParams()
    {
        return $_POST;
    }

}