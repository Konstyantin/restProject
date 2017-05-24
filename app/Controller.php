<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.05.2017
 * Time: 15:09
 */
namespace App;


/**
 * Class Controller
 *
 * Base controller class with store base must have methods
 *
 * @package App
 */
abstract class Controller
{
    /**
     * Render view with layout component
     *
     * @param string $view
     * @param null $data
     * @return bool
     */
    protected function render(string $view, $data = null)
    {
        // path to directory which is store view files
        $path = ROOT . '/src/View/' . $view . '.phtml';
        if (file_exists($path)) {
            require_once(ROOT . '/app/layout/header.phtml');   // include header layout
            require_once($path);
            require_once(ROOT . '/app/layout/footer.phtml');   // include footer layout
        }

        return false;
    }
}