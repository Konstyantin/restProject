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
     * Get response status
     *
     * @return int
     */
    public static function getStatus()
    {
        return (string) http_response_code();
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
        return  header('Content-Type: ' . $type);
    }

    /**
     * Check exists X-AUTH_TOKEN in response header
     *
     * @return bool
     */
    public static function checkHeaderToken()
    {
        $result = apache_response_headers();

        return ($result['X-AUTH_TOKEN']) ? true : false;
    }

    /**
     * Return X-AUTH_TOKEN if token exists
     *
     * @return array|false
     */
    public static function getAuthToken()
    {
        if (self::checkHeaderToken()) {
            $headerResponse = apache_response_headers();
            return $headerResponse['X-AUTH_TOKEN'];
        }

        return false;
    }

    /**
     * Set X-AUTH_TOKEN token
     *
     * @param string $token
     */
    public static function setAuthToken(string $token)
    {
        return header('X-AUTH_TOKEN: ' . $token);
    }
}