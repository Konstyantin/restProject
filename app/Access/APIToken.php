<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.03.2017
 * Time: 14:33
 */
namespace App\Access;

/**
 * Class APIToken
 * @package App\Access
 */
class APIToken
{
    /**
     * @var array $tokenData data for generate token
     */
    private $tokenData = [];

    /**
     * @var string $token Authentication token
     */
    private $token;

    /**
     * Create token for Authentication user
     *
     * @param int $id
     * @return string
     */
    public function createToken(int $id)
    {
        // set data for generate token
        $this->setTokenData($id);

        $encodeToken = $this->encodeToken($this->tokenData);

        $this->token = $encodeToken;

        return $this->token;
    }

    /**
     * Encode token by passed data
     *
     * The resulting @param $tokenData array first using json_encode covert
     * into JSON object after using base64_encode convert JSON data into token string
     *
     * @param array $tokenData
     * @return string
     */
    private function encodeToken(array $tokenData)
    {
        return base64_encode(json_encode($tokenData));
    }

    /**
     * Decode token string into object
     *
     * The taken @param $token string using base64_decode convert into JSON object after
     * result JSON object using json_decode convert into php object
     *
     *
     * @param string $token
     * @return object
     */
    private function decodeToken(string $token)
    {
        return json_decode(base64_decode($token));
    }


    /**
     * Set token data
     *
     * @param int $id id user which checked authentication
     */
    private function setTokenData(int $id)
    {
        // user id
        $this->tokenData['id'] = $id;

        //time create token
        $this->tokenData['time'] = time();
    }

    /**
     * Get data stored toked
     *
     * Return property object
     *
     * @param string $token
     * @return object
     */
    public function getTokenData(string $token)
    {
        return $this->decodeToken($token);
    }
}