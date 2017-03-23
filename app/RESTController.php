<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 09:41
 */

namespace App;

use App\Access\APITokenAuth;
use App\RequestMethod;
use App\Request;

/**
 * Class RESTController
 * @package App
 */
class RESTController
{
    /**
     * Call rest method which don't take param
     */
    public function itemAction()
    {
        $apiAuth = new APITokenAuth();

        // check exist X-AUTH_TOKEN in header
        if (Request::checkHeaderToken()) {

            // X-AUTH_TOKEN
            $token = Request::getAuthToken();

            // check exist user with this passed token
            if ($apiAuth->checkAccess($token)) {

                $request = new RequestMethod();

                return $request->selectMethod($this);
            }
        }

        $apiAuth->onAuthFailure();
    }

    /**
     * Call rest method which take param
     *
     * @param int $id
     * @return mixed
     */
    public function itemParamAction(int $id)
    {

        $apiAuth = new APITokenAuth();

        // check exist X-AUTH_TOKEN in header
        if (Request::checkHeaderToken()) {

            // X-AUTH_TOKEN
            $token = Request::getAuthToken();

            // check exist user with this passed token
            if ($apiAuth->checkAccess($token)) {

                $request = new RequestMethod();

                return $request->selectMethod($this, $id);
            }
        }

        $apiAuth->onAuthFailure();
    }
}