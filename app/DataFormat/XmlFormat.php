<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 11:35
 */

namespace App\DataFormat;

use App\DataFormat\Format;
use App\Request;

/**
 * Class XmlFormat
 * Component for convert data XML type
 */
class XmlFormat extends Format
{
    /**
     * Method convert array data to xml
     *
     * @param array $data
     * @param string $rootNodeName
     * @param null $xml
     * @return mixed
     */
    public static function encode(array $data, $rootNodeName = 'post', $xml=null)
    {
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }

        // loop through the data passed in.
        foreach($data as $key => $value) {
            // no numeric keys in our xml please!
            if (is_numeric($key)) {
                // make string key...
                $key = "unknownNode_". (string) $key;
            }

            // replace anything not alpha numeric
            $key = preg_replace('/[^a-z]/i', '', $key);

            // if there is another array found recrusively call this function
            if (is_array($value)) {
                $node = $xml->addChild($key);
                // recrusive call.
                XmlFormat::encode($value, $rootNodeName, $node);
            } else {
                // add single node.
                $value = htmlentities($value);
                $xml->addChild($key,$value);
            }
        }

        Request::setContentType('application/xml');
        // pass back as string. or simple xml object if you want!
        return $xml->asXML();
    }

    /**
     * Method convert data send in Object type
     *
     * @return \SimpleXMLElement
     */
    public static function decode()
    {
        return simplexml_load_file('php://input');
    }
}