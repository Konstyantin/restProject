<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 09:41
 */

namespace App;

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
        $request = new RequestMethod();

        $request->selectMethod($this, $id);
    }
}