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

$rootDir = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
define('ROOT_DIR', $rootDir);
define('ROOT', dirname(__FILE__));
define('TIME', time());

$router = new Router();
$router->run();

Db::connect();
