<?php

/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:20
 */
namespace App;

class Router
{
    /**
     * @var array
     */
    private $routes;
    /**
     * Router constructor.
     *
     * Get all routes
     */
    public function __construct()
    {
        $routePath = ROOT . '/app/config/routes.php';
        $this->routes = include($routePath);
    }
    /**
     * Get URI
     *
     * @return string
     */
    public function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'],'/');
        }
    }

    /**
     * Initiate Router
     */
    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $pos = strpos($uri, $uriPattern);
                $uri = substr($uri, $pos);
                return $this->defineComponents($uriPattern, $path, $uri);
            }
        }
    }

    /**
     * Determine Bundle Controller and Action by URI
     *
     * @param string $pattern
     * @param string $path
     * @param string $uri
     * @return bool
     */
    public function defineComponents($pattern, $path, $uri)
    {
        $internalRoute = preg_replace("~$pattern~", $path, $uri);

        $segments = explode('/', $internalRoute);

        $controllerName = ucfirst(array_shift($segments)) . 'Controller';

        $actionName = array_shift($segments) . 'Action';

        $parameters = $segments;

        $controllerFile = ROOT . '/src/Controller/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {

            include_once($controllerFile);

            $controllerObject = "Acme\\" . $controllerName;

            $controllerObject = new $controllerObject;

            $result = call_user_func_array([$controllerObject, $actionName], $parameters);

            if ($result != null) {
                return false;
            }
        }

    }
}