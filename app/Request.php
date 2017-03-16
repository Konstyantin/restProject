<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 13:22
 */
namespace App;

/**
 * Class Request
 * @package App
 */
class Request
{
    /**
     * @return int
     */
    public static function getStatus()
    {
        return (string) http_response_code();
    }

    /**
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
        return  header('Content-Type: ' . $type);
    }
}