<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 12:40
 */

namespace App\DataFormat;

/**
 * Class Format
 * @package App\DataFormat
 */
abstract class Format
{
    /**
     * Method encode
     *
     * @param array $data
     * @return mixed
     */
    abstract public static function encode(array $data);

    /**
     * Method decode
     *
     * @return mixed
     */
    abstract public static function decode();
}