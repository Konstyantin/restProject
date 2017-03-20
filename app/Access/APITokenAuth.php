<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.03.2017
 * Time: 15:12
 */

namespace App\Access;

use App\Access\UserEntity;
use App\Access\TokenLifeCycle;
use App\Request;
use App\StatusRequest;

/**
 * Class APITokenAuth
 *
 * Component for provide access to REST
 * @package App\Access
 */
class APITokenAuth
{
    /**
     * Check access user using REST extension
     *
     * @return bool|void
     */
    public function checkAccess(UserEntity $user)
    {
        if ($user) {

            $tokenLife = new TokenLifeCycle($user);

            // check lifetime user token if need generate new token
            if ($tokenLife->supportedToken()) {

                $userToken = $this->getUserToken($user);

                // check match send token and response token
                $responseToken = $this->checkMatchToken($userToken);

                // if user not found call onAuthFailure
                $checkToken = $user->getUserByToken($responseToken);

                return (!$checkToken) ? $this->onAuthFailure() : $this->onAuthSuccess();
            }
        }

        $this->onAuthFailure();
    }

    /**
     * Check request and response token
     *
     * @param string $token
     * @return array|bool|false
     */
    public function checkMatchToken(string $token)
    {
        Request::setAuthToken($token);

        $responseToken = Request::getAuthToken();

        if ($responseToken === $token) {
            return $responseToken;
        }
        return false;
    }

    /**
     * @param \App\Access\UserEntity $user
     * @return mixed
     */
    public function getUserToken(UserEntity $user)
    {
        $tokenData = $user->getUserTokenData();

        return $tokenData->token;
    }

    /**
     * Call when authentication is success
     *
     * @return bool
     */
    public function onAuthSuccess()
    {
        return true;
    }

    /**
     * Call when authentication is fail
     *
     * Set status FORBIDDEN 403
     */
    public function onAuthFailure()
    {
        Request::setStatus(StatusRequest::POST_FORBIDDEN);die();
    }
}