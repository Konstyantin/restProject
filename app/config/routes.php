<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 14.03.17
 * Time: 20:29
 */

/**
 * Store route
 */
return [
//    'post/([0-9]+)' => 'post/itemParam/$1',
    'post/' => 'post/itemParam/$1', // get, delete, put
    'post' => 'post/item'           // post
];