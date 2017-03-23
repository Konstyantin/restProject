<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.03.2017
 * Time: 11:16
 */

namespace App\Access;

use Acme\Entity\User;
use App\Access\APIToken;

/**
 * Class TokenLifeCycle
 *
 * Component for work with token lifecycle
 * @package App\Access
 */
class TokenLifeCycle extends APIToken
{
    /**
     * @var int $tokenTime time where token was created
     */
    private $tokenTime;

    /**
     * @var int $tokenExpire default 3600
     */
    private $tokenExpire;

    /**
     * @var User|\App\Access\UserEntity
     */
    private $user;

    /**
     * TokenLifeCycle constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->findTokeTimeParams();
    }

    /**
     * Get token time
     *
     * @return int
     */
    public function getTokenTime()
    {
        return $this->tokenTime;
    }

    /**
     * Set token time
     *
     * @param int $tokenTime
     */
    public function setTokenTime($tokenTime)
    {
        $this->tokenTime = $tokenTime;
    }

    /**
     * Get token expire
     *
     * @return int
     */
    public function getTokenExpire()
    {
        return $this->tokenExpire;
    }

    /**
     * Set token expire
     *
     * @param int $tokenExpire
     */
    public function setTokenExpire($tokenExpire)
    {
        $this->tokenExpire = $tokenExpire;
    }


    /**
     * Find token param
     *
     * Set token time and tokenExpire
     */
    private function findTokeTimeParams()
    {
        // user token from database store token and token_expire field
        $userToken = $this->user->getUserTokenData();

        // user token
        $token = $userToken->token;

        // get token param id and time created
        $tokenParam = $this->getTokenData($token);

        // user token expire
        $tokenExpire = $userToken->token_expire;

        //assign received value to property
        $this->tokenExpire = $tokenExpire;
        $this->tokenTime = $tokenParam->time;
    }

    /**
     * Update user token
     *
     * Set new value for user token
     *
     * @param string $token
     * @return bool
     */
    protected function updateToken(string $token)
    {
        return $this->user->updateUserToken($token);
    }

    /**
     * Calculate lifetime token regarding now time
     *
     * @return bool
     */
    protected function diffTokenTimeExpire()
    {
        $tokenLife = $this->tokenTime + $this->tokenExpire;

        return ($tokenLife < time()) ? false : true;
    }

    /**
     * Check support token
     *
     * Check actual token lifetime is fished then create new
     * token and set this token for select user
     *
     * @return bool
     */
    public function supportedToken()
    {
        if (!$this->diffTokenTimeExpire()) {
            $newToken = $this->createToken($this->user->getId());

            $this->user->updateUserToken($newToken);
        }
        return true;
    }
}