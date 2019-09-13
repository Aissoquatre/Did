<?php

namespace SP\Commons\Libs;

/**
 * Class StringTool
 *
 * @package Sp\Commons\Libs
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class StringTool
{
    /**
     * @param string|array string
     * @return string|array
     */
    public static function sanitize($string)
    {
        if (is_array($string)) {
            foreach ($string as &$item) {
                $item = self::sanitize($item);
            }
        } else {
            $string = strip_tags($string);
        }

        return $string;
    }
}