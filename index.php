<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2017
 * Time: 12:18
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Router;
use App\Db;
use Acme\Entity\Post;

require_once __DIR__ . '/vendor/autoload.php';

define('ROOT', dirname(__FILE__));

$router = new Router();
$router->run();

Db::connect();

$post = new Post();
