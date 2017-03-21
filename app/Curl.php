<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.03.2017
 * Time: 19:14
 */

namespace App;

/**
 * Class Curl
 * @package App
 */
class Curl
{
    private $token;
    /**
     * Get post
     *
     * @param int $id
     */
    public function getAction(int $id)
    {
        $url = 'http://dcodeit.net/kostya.nagula/project/restProject/post/' . $id;

        $header = [
            'X-AUTH_TOKEN: eyJpZCI6MSwidGltZSI6MTQ5MDA5MDUyMX0='
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_RETURNTRANSFER => true,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        echo $status = $this->getStatus($curl);

        http_response_code($status);

        echo $result;

        curl_close($curl);

    }

    /**
     * Call post request
     *
     * Create new post
     */
    public function postAction(array $data)
    {
        $url = 'http://dcodeit.net/kostya.nagula/project/restProject/post';

        $postData = [
            'title'     => 'curl title',
            'content'   => 'curl content',
            'author'    => 'curl author',
        ];

        $header = [
            'X-AUTH_TOKEN: eyJpZCI6MSwidGltZSI6MTQ5MDA5MDUyMX0='
        ];

        $jsonPostData = json_encode($postData);

        $curl = curl_init();

        $options = [
            CURLOPT_URL             => $url,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $jsonPostData,
            CURLOPT_RETURNTRANSFER  => true,
        ];

        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        echo $status = $this->getStatus($curl);

        http_response_code($status);

        curl_close($curl);
    }

    /**
     * @param int $id
     */
    public function putAction(int $id, array $data)
    {
        $url = 'http://dcodeit.net/kostya.nagula/project/restProject/post/' . $id;

        $postData = [
            'title'     => 'curl update title',
            'content'   => 'curl update content',
            'author'    => 'curl author',
        ];

        $jsonPostData = json_encode($postData);

        $header = [
            'Content_length: ' . strlen($jsonPostData),
            'X-AUTH_TOKEN: eyJpZCI6MSwidGltZSI6MTQ5MDA5MDUyMX0='
        ];

        $curl = curl_init();

        $options = [
            CURLOPT_URL             => $url,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_CUSTOMREQUEST   => 'PUT',
            CURLOPT_POSTFIELDS      => $jsonPostData,
            CURLOPT_RETURNTRANSFER  => true,
        ];

        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        echo $status = $this->getStatus($curl);

        http_response_code($status);

        curl_close($curl);
    }

    /**
     * @param int $id
     */
    public function deleteAction(int $id)
    {
        $url = 'http://dcodeit.net/kostya.nagula/project/restProject/post/' . $id;

        $curl = curl_init();

        $header = [
            'X-AUTH_TOKEN: eyJpZCI6MSwidGltZSI6MTQ5MDA5MDUyMX0='
        ];

        $curl = curl_init();

        $options = [
            CURLOPT_URL             => $url,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_CUSTOMREQUEST   => 'DELETE',
            CURLOPT_RETURNTRANSFER  => true,
        ];

        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        echo $status = $this->getStatus($curl);

        http_response_code($status);

        curl_close($curl);
    }

    /**
     * Get status response
     *
     * @param $curl
     * @return mixed
     */
    public function getStatus($curl)
    {
        return curl_getinfo($curl, CURLINFO_HTTP_CODE);
    }
}