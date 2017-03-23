<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.03.2017
 * Time: 15:12
 */

namespace App\Access;

use Acme\Entity\User;
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
    public function checkAccess(string $token)
    {
        return User::getUserByToken($token);
    }

    /**
     * Get user token
     *
     * Get token which have user
     *
     * @param User $user
     * @return mixed
     */
    public function getUserToken(User $user)
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
        Request::setStatus(StatusRequest::POST_FORBIDDEN);
        die();
    }
}