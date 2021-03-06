<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2017
 * Time: 09:34
 */

require_once __DIR__ . '/vendor/autoload.php';

define('ROOT', dirname(__FILE__));

use App\Request;
use Acme\Entity\User;
use App\Access\TokenLifeCycle;

/**
 * Class Curl
 *
 * Component for test REST API with cURL
 * @package App
 */
class Curl
{
    /**
     * @var object User user
     */
    private $user;

    /**
     * Host for project
     *
     * @var string $host
     */
    private $host;

    /**
     * Path to file
     *
     * @var string $path
     */
    private $path;

    /**
     *
     * Curl constructor.
     * @param User $user
     */
    public function __construct(User $user, string $host, string $path)
    {
        $this->user = $user;

        $this->setHost($host);
        $this->setPath($path);

    }

    /**
     * Set host
     *
     * @param string $host
     */
    public function setHost(string $host)
    {
        $host = rtrim($host, DIRECTORY_SEPARATOR);

        $this->host = $host;
    }

    /**
     * Get path to file
     *
     * @param string $path
     */
    public function setPath(string $path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        $this->path = $path;
    }

    /**
     * Get user token and check lifetime token is finish generate new token
     *
     * @return mixed
     */
    public function getUserToken()
    {
        $tokenLife = new TokenLifeCycle($this->user);

        if ($tokenLife->supportedToken()) {
            return $this->user->getUserTokenData()->token;
        }
    }

    /**
     * Get post method
     *
     * @param int $id
     */
    public function getAction(int $id)
    {
        // url path
        $url = 'http://' . $this->host .  '/' . $this->path . '/post/' . $id;

        // set auth token
        $header = [
            'X-AUTH_TOKEN: ' . $this->getUserToken()
        ];

        // curl options
        $options = [
            CURLOPT_URL             => $url,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_RETURNTRANSFER  => true,
        ];

        $curl = curl_init();

        // set curl options
        curl_setopt_array($curl, $options);

        // result execute
        $result = curl_exec($curl);

        // check for errors
        $this->checkError($result, $curl);
        // response status
        Request::setStatus($this->getStatus($curl));

        echo $result;

        curl_close($curl);
    }

    /**
     * Call post request method
     *
     * Create new post
     */
    public function postAction(array $data)
    {
        // url path
        $url = 'http://' . $this->host .  '/' . $this->path . '/post/';

        // header data
        $header = [
            'Content-Type: application/json',           // set content-type
            'X-AUTH_TOKEN: ' . $this->getUserToken(),   // set Auth token
        ];

        // convert post data to JSON
        $jsonPostData = json_encode($data);

        $curl = curl_init();

        // curl options
        $options = [
            CURLOPT_URL             => $url,            // provide the URL to use in the request
            CURLOPT_HTTPHEADER      => $header,         // set HTTP header field
            CURLOPT_POST            => true,            // set HTTP method POST
            CURLOPT_POSTFIELDS      => $jsonPostData,   // the full data to post in a HTTP "POST" operation
            CURLOPT_RETURNTRANSFER  => true,            // return result execute as string
        ];

        // set curl options
        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        // check for errors
        $this->checkError($result, $curl);

        // response status
        Request::setStatus($this->getStatus($curl));

        curl_close($curl);
    }

    /**
     * Call put request method
     *
     * @param int $id
     * @param array $data
     */
    public function putAction(int $id, array $data)
    {
        // url path
        $url = 'http://' . $this->host .  '/' . $this->path . '/post/' . $id;

        // convert post data to JSON
        $jsonPostData = json_encode($data);

        // header data
        $header = [
            'Content-Type: application/json',           // set content-type
            'Content_length: ' . strlen($jsonPostData), // set content value content-lenght
            'X-AUTH_TOKEN: ' . $this->getUserToken(),   // set Auth token
        ];

        $curl = curl_init();

        // curl options
        $options = [
            CURLOPT_URL             => $url,            // provide the URL to use in the request
            CURLOPT_HTTPHEADER      => $header,         // set HTTP header field
            CURLOPT_CUSTOMREQUEST   => 'PUT',           // custom request method "PUT"
            CURLOPT_POSTFIELDS      => $jsonPostData,   // the full data to post in a HTTP "PUT" operation
            CURLOPT_RETURNTRANSFER  => true,            // return result execute as string
        ];

        // set curl options
        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        // check for errors
        $this->checkError($result, $curl);

        // response status
        Request::setStatus($this->getStatus($curl));

        curl_close($curl);
    }


    /**
     * Call delete request method
     *
     * @param int $id
     */
    public function deleteAction(int $id)
    {
        // url path
        $url = 'http://' . $this->host .  '/' . $this->path . '/post/' . $id;

        $curl = curl_init();

        // header data
        $header = [
            'X-AUTH_TOKEN: ' . $this->getUserToken(),   // set Auth token
        ];

        $curl = curl_init();

        // curl options
        $options = [
            CURLOPT_URL             => $url,            // provide the URL to use in the request
            CURLOPT_HTTPHEADER      => $header,         // set HTTP header field
            CURLOPT_CUSTOMREQUEST   => 'DELETE',        // custom request method "PUT"
            CURLOPT_RETURNTRANSFER  => true,            // return result execute as string
        ];

        // set curl options
        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        // check for errors
        $this->checkError($result, $curl);

        // response status
        Request::setStatus($this->getStatus($curl));

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

    /**
     * Check cURL execute error
     *
     * @param $curl
     */
    public function checkError($result, $curl)
    {
        if ($result === false) {
            echo 'Error' . curl_error($curl);
        }
    }
}


$data = [
    'title'     => 'curl update title',
    'content'   => 'curl update content',
    'author'    => 'curl author',
];

// get user which user_id = 1
$user = new User(1);

// implement Curl
$curl = new Curl($user, 'dcodeit.net', 'kostya.nagula/project/restProject/');

//$curl->getAction(65);         // get
$curl->postAction($data);     // post
//$curl->putAction(94,$data);   // put
//$curl->deleteAction(94);      // delete
