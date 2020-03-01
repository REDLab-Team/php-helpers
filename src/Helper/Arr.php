<?php

namespace Redlab\Helper;

/**
 * This class contains methods to manipulates arrays in the application.
 *
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class Arr
{
    /**
     * Return the first value of an array. If the key parameter is true then the first key will be returned.
     *
     * @param array $array
     * @param bool $key
     *
     * @return int|mixed|string|null
     */
    public static function first(array $array, bool $key = false)
    {
        return $key === false ? reset($array) : array_key_first($array);
    }

    /**
     * Return the last value of an array. If the key parameter is true then the last key will be returned.
     *
     * @param array $array
     * @param bool $key
     *
     * @return int|mixed|string|null
     */
    public static function last(array $array, bool $key = false)
    {
        return $key === false ? end($array) : array_key_last($array);
    }

    /**
     * Sort an array. If the reverse parameter is true then it will sort by reverse.
     *
     * @param array $array
     * @param bool $reverse
     * @param int $sortFlag
     *
     * @return bool
     */
    public static function sort(array &$array, bool $reverse = false, int $sortFlag = SORT_REGULAR): bool
    {
        return $reverse === false ? sort($array, $sortFlag) : rsort($array, $sortFlag);
    }

    /**
     * Add a value to the beginning of an array.
     * If the beginning parameter is false, the value will be add at the end of the array.
     *
     * @param array $array
     * @param $mixedValue
     * @param bool $beginning
     *
     * @return int
     */
    public static function add(array &$array, $mixedValue, bool $beginning = true): int
    {
        if (is_array($mixedValue)) {
            foreach ($mixedValue as $value) {
                self::add($array, $value, $beginning);
            }
            return count($array);
        } else {
            return $beginning === true ? array_unshift($array, $mixedValue) : array_push($array, $mixedValue);
        }
    }

    /**
     * Check if the key exists into the array parameter.
     *
     * @param $key
     * @param array $array
     *
     * @return bool
     */
    public static function keyExists($key, array $array): bool
    {
        return key_exists($key, $array);
    }

    /**
     * Return the value that corresponds to the key parameter.
     * If the key does not exists or the value is empty, it will check the otherKey parameter if it's not null.
     * Then it will return null.
     *
     * @param $key
     * @param array $array
     * @param null $otherKey
     *
     * @return mixed|null
     */
    public static function value($key, array $array, $otherKey = null)
    {
        return self::keyExists($key, $array) ? $array[$key]
            : (self::keyExists($otherKey, $array) ? $array[$otherKey] : null);
    }

    /**
     * Returns a numerically ordered array with the keys of the array as values.
     *
     * @param array $array
     * @param null $searchValue
     * @param bool $strict
     *
     * @return array
     */
    public static function keys(array $array, $searchValue = null, bool $strict = false): array
    {
        return $searchValue !== null ? array_keys($array, $searchValue, $strict) : array_keys($array);
    }

    /**
     * Returns a numerically ordered array with the values of the array.
     *
     * @param array $array
     *
     * @return array
     */
    public static function values(array $array): array
    {
        return array_values($array);
    }

    /**
     * Alias of the values method.
     *
     * @param array $array
     *
     * @return array
     */
    public static function toNumIndexed(array $array): array
    {
        return self::values($array);
    }

    /**
     * Exchanges keyx with values in an array.
     * If the $sort parameter is true then the new array will be sorted.
     * The sort type depends of the recursive parameter.
     * If the sortByKeys parameter is true then the sort type will be done on the keys.
     *
     * @param array $array
     * @param bool $sort
     * @param bool $recursive
     * @param bool $sortByKeys
     *
     * @return array
     */
    public static function flip(array $array, bool $sort = false, bool $recursive = false, bool $sortByKeys = false): array
    {
        if ($sort !== false) {
            if ($sortByKeys === true) {
                $keys = self::keys($array);
                $recursive === false ? self::sort($keys) : self::sort($keys, true);
                $newArray = [];
                foreach ($keys as $key) {
                    $newArray[$key] = $array[$key];
                }
                $array = $newArray;
            } else {
                $recursive === false ? self::sort($array) : self::sort($array, true);
            }
        }
        return array_flip($array);
    }
}