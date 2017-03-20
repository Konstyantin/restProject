<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 09:41
 */

namespace App;

use App\Access\APITokenAuth;
use App\Access\UserEntity;
use App\RequestMethod;


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
        $auth = new APITokenAuth();

        $user = new UserEntity(1);

        $auth->checkAccess($user);

        $request = new RequestMethod();

        $request->selectMethod($this);
    }

    /**
     * Call rest method which take param
     *
     * @param int $id
     */
    public function itemParamAction(int $id)
    {
        $auth = new APITokenAuth();

        $user = new UserEntity(1);

        $auth->checkAccess($user);

        $request = new RequestMethod();

        $request->selectMethod($this, $id);
    }
}