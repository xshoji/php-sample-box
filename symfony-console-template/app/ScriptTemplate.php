<?php

require_once __FILE__;

$array = [
    "aaa" => "aaa",
    "bbb" => "bbb",
    "ccc" => [
        "xxx" => "xxx",
        "yyy" => "yyy",
        "zzz" => [
            111,
            222,
            333
        ],
    ],
];

ScriptUtil::println("raw");
ScriptUtil::printlnMultiple($array);
ScriptUtil::println("");
ScriptUtil::println(ScriptUtil::getValue($array, "aaa"));
ScriptUtil::println("");
ScriptUtil::printlnMultiple(ScriptUtil::getValue($array, "ccc"));
ScriptUtil::println("");
ScriptUtil::printlnMultiple(ScriptUtil::getValueHierarchy($array, ["ccc", "zzz"]));
        

/**
 * 
 * @author nsgeorge
 * @license MIT (see LICENSE.md)
 */
class ScriptUtil
{

    /**
     * Command info
     *
     * @var array
     */
    protected static $scriptinfo = array();

    /**
     * Get user
     *
     * @return string|null
     */
    public static function getUser()
    {
        if (!array_key_exists('user', self::$scriptinfo)) {
            self::$scriptinfo['user'] = rtrim(shell_exec('whoami'));
        }
        return self::getValue(self::$scriptinfo, 'user');
    }

    /**
     * Get time current.
     *
     * @return \DateTime
     */
    public static function getTimeCurrent()
    {
        return (new \DateTime())->setTimestamp(time());
    }

    /**
     * Get Host
     *
     * @return string
     */
    public function getHost()
    {
        return gethostname();
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        if (!array_key_exists('path', self::$scriptinfo)) {
            $reflection = new \ReflectionClass($this);
            $this->setPath($reflection->getFileName());
            self::$scriptinfo['path'] = $reflection->getFileName();
        }
        return self::getValue($this->scriptinfo, 'path');
    }

    /**
     * Get memory peak
     *
     * @return string
     */
    public static function getMemoryPeakUsedString()
    {
        $memory_bytes = memory_get_peak_usage(true);

        // Formats bytes into a human readable string if $this->useFormatting is true, otherwise return $bytes as is
        if ($memory_bytes > 1024*1024) {
            return round($memory_bytes/1024/1024, 2).' MB';
        } elseif ($memory_bytes > 1024) {
            return round($memory_bytes/1024, 2).' KB';
        }

        return $memory_bytes . ' B';
    }
    
    /**
     * 
     * @param type $string
     */
    public static function println($string)
    {
        echo self::getUser() . " " . self::getTimeCurrent()->format("Y-m-d H:i:s") . " | " . $string . PHP_EOL;
    }
    /**
     * 
     * @param array $values
     * @param string $intent
     */
    public static function printlnMultiple(array $values, $intent = "")
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                self::println($intent . $key);
                self::printlnMultiple($value, $intent . "  ");
            } else {
                self::println($intent . $key . " : " . $value);
            }
        }
    }
    
    /**
     * @param $array
     * @param $key
     * @param $default [default: null]
     * @return mixed
     */
    public static function getValue($array, $key, $default = null)
    {
        if (!is_array($array)) {
            return $default;
        }

        if (!array_key_exists($key, $array)) {
            return $default;
        }

        return $array[$key];
    }
    
    /**
     * @param $array
     * @param $key
     * @param $default [default: null]
     * @return mixed
     */
    public static function getValueHierarchy($array, array $keys, $default = null)
    {

        $result = $array;
        foreach ($keys as $key) {
            $result = self::getValue($result, $key, $default);
        }
        return $result;
    }
}
