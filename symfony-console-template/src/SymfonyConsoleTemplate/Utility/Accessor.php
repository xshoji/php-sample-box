<?php

namespace SymfonyConsoleTemplate\Utility;

use Symfony\Component\PropertyAccess\PropertyAccess as SymfonyPropertyAccess;

/**
 * Accessor
 *
 * @author 
 * @license MIT (see LICENSE.md)
 */
class Accessor
{

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private static $symfony_property_accessor = null;

    /**
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected static function getSymfonyPropertyAccessor()
    {
        if (is_null(self::$symfony_property_accessor)) {
            self::$symfony_property_accessor = SymfonyPropertyAccess::createPropertyAccessor();
        }
        return self::$symfony_property_accessor;
    }

    /**
     * @param $array
     * @param $key
     * @param $default [default: null]
     * @return mixed
     */
    public static function getValue($array, $key, $default = null)
    {
        if (!is_array($array) && !is_object($array)) {
            return $default;
        }

        if (is_array($array)) {
            $key = "[" . $key . "]";
        }

        $result = self::getSymfonyPropertyAccessor()->getValue($array, $key);
        if (is_null($result)) {
            return $default;
        }

        return $result;
    }


    /**
     * @param $array
     * @param $keys
     * @param $default [default: null]
     * @return mixed
     */
    public static function getValueHierarchy($array, array $keys, $default = null)
    {
        if (!is_array($array) && !is_object($array)) {
            return $default;
        }

        if (is_array($array)) {
            $key = "[" . implode("][", $keys) . "]";
        }
        if (is_object($array)) {
            $key = implode(".", $keys);
        }

        $result = self::getSymfonyPropertyAccessor()->getValue($array, $key);
        if (is_null($result)) {
            return $default;
        }

        return $result;
    }
}
