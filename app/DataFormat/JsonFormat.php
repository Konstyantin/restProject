<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 12:06
 */

namespace App\DataFormat;

use App\DataFormat\Format;
use App\Request;

/**
 * Class JsonFormat
 * Component for work with Json
 * @package App
 */
class JsonFormat extends Format
{
    /**
     * Convert Array into Json
     *
     * @param array $data
     * @return string
     */
    public static function encode(array $data)
    {
        Request::setContentType('application/json');

        return json_encode($data);
    }

    /**
     * Convert received Json into Object
     *
     * @return mixed
     */
    public static function decode()
    {
        $json = file_get_contents('php://input');
        return json_decode($json);
    }
}