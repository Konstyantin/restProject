<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 12:47
 */

namespace App\DataFormat;

/**
 * Class FactoryFormat
 * @package App\DataFormat
 */
class FactoryFormat
{
    /**
     * Decode passed array data into JSON or XML format
     *
     * @param array $data
     * @param string $type
     * @return bool|mixed|string
     */
    public function encode(array $data, $type = 'application/json')
    {
        switch ($type) {
            case 'application/xml' :
                return XmlFormat::encode($data);
            case 'application/json' :
                return JsonFormat::encode($data);
            default:
                return false;
        }
    }

    /**
     * Encode data into passed type JSON or XML
     *
     * @param string $type
     * @return bool|mixed|\SimpleXMLElement
     */
    public function decode($type)
    {
        switch ($type) {
            case 'application/xml' :
                return XmlFormat::decode();
            case 'application/json' :
                return JsonFormat::decode();
            default:
                return false;
        }
    }
}