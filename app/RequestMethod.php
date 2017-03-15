<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.03.2017
 * Time: 11:50
 */

namespace App;

/**
 * Class Request
 *
 * Component for work with requestMethod
 */
class RequestMethod
{
    /**
     * @var array $methods define request which allow take a param
     */
    private $methodsParam = [
        'get'       => true,
        'post'      => false,
        'put'       => true,
        'delete'    => true
    ];

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Select method in class appropriate request method
     *
     * @param $class
     * @param null $param
     * @return mixed
     */
    public function selectMethod($class, $param = null)
    {
        // get request method
        $requestMethod = $this->getMethod();

        foreach ($this->methodsParam as $method => $methodParam) {

            // check appropriate method available parameter
            if ($requestMethod == $method && $param == $methodParam) {
                $classMethod = $this->getClassMethod($class);

                // check class have appropriate public method
                foreach ($classMethod as $method) {
                    if (preg_match("/^$requestMethod/", $method)) {
                        return $this->callMethod($class, $method, $param);
                    }
                }
            }
        }
        return false;
    }

    /**
     * Call method in passed class
     *
     * @param $class
     * @param $method
     * @param int|null $param
     * @return mixed
     */
    public function callMethod($class, $method,  int $param = null)
    {
        return call_user_func([$class, $method], $param);
    }

    /**
     * Get public exist method from class
     * @param $class
     * @return array
     */
    public function getClassMethod($class)
    {
        return get_class_methods($class);
    }
}