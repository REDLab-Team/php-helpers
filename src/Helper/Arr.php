<?php

namespace RedlabTeam\Helper;

use \StdClass;

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
        return self::isEmpty($array) ? null : ($key === false ? reset($array) : array_key_first($array));
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
        return self::isEmpty($array) ? null : ($key === false ? end($array) : array_key_last($array));
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
     * Check if the value exists into the array parameter.
     * The strict parameter checks the type of the variable
     *
     * @param $key
     * @param array $array
     * @param $strict
     *
     * @return bool
     */
    public static function exists($key, array $array, $strict = false): bool
    {
        return in_array($key, $array, $strict);
    }

    /**
     * Check if the key exists into the array parameter.
     * If the caseSensitive parameter is false then it will search the key without checking the case
     *
     * @param $key
     * @param array $array
     * @param bool $caseSensitive
     *
     * @return bool
     */
    public static function keyExists($key, array $array, $caseSensitive = true): bool
    {
        if ($caseSensitive === true || ! is_string($key)) {
            return key_exists($key, $array);
        }

        $keys = self::keysLower($array);

        return self::exists(strtolower($key), array_keys($keys));
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
     * Check if the $array parameter contains values
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isEmpty(array $array): bool
    {
        return count($array) === 0;
    }

    /**
     * Check if the $array parameter is an associative array
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isAssoc(array $array): bool
    {
        return ! self::isEmpty(array_filter(self::keys($array), 'is_string'));
    }

    /**
     * Exchanges keys with values in an array.
     * If the $sort parameter is true then the new array will be sorted.
     * The sort type depends of the $reverse parameter.
     * If the $sortByKeys parameter is true then the sort type will be done on the keys.
     *
     * @param array $array
     * @param bool $sort
     * @param bool $reverse
     * @param bool $sortByKeys
     *
     * @return array
     */
    public static function flip(array $array, bool $sort = false, bool $reverse = false, bool $sortByKeys = false): array
    {
        if ($sort !== false) {
            if ($sortByKeys === true) {
                $keys = self::keys($array);
                $reverse === false ? self::sort($keys) : self::sort($keys, true);
                $newArray = [];
                foreach ($keys as $key) {
                    $newArray[$key] = $array[$key];
                }
                $array = $newArray;
            } else {
                $reverse === false ? self::sort($array) : self::sort($array, true);
            }
        }

        // Only flip and integer values can be flipped
        $returnArray = array_map(function($value) {
            return is_int($value) || is_string($value) ? $value : '';
        }, $array);

        return array_flip($returnArray);
    }

    /**
     * Convert an associative array to an object.
     *
     * @param array $array
     *
     * @return StdClass
     */
    public static function arrayToObject(array $array): StdClass
    {
        $jsonHelper = new Json();

        return self::isAssoc($array) ? $jsonHelper->decode($jsonHelper->encode($array), false) : new StdClass();
    }

    /**
     * Convert an object to an associative array.
     *
     * @param object $object
     *
     * @return array
     */
    public static function objectToArray(object $object): array
    {
        $jsonHelper = new Json();

        return $jsonHelper->decode($jsonHelper->encode($object), true);
    }

    /**
     * Change the case of the keys in an associative array. The case depends of the 2nd parameter.
     *
     * @param array $array
     * @param int $case
     *
     * @return array
     */
    public static function changeKeysCase(array $array, int $case = CASE_LOWER): array
    {
        return array_change_key_case($array, $case);
    }

    /**
     * Set the keys of the array passed into parameter to upper case.
     *
     * @param array $array
     *
     * @return array
     */
    public static function keysUpper(array $array): array
    {
        return self::changeKeysCase($array, CASE_UPPER);
    }

    /**
     * Set the keys of the array passed into parameter to lower case.
     *
     * @param array $array
     *
     * @return array
     */
    public static function keysLower(array $array): array
    {
        return self::changeKeysCase($array);
    }

    /**
     * Set the keys of the array passed into parameter to capitalize case (first character upper, others lower).
     *
     * @param array $array
     *
     * @return array
     */
    public static function keysCapitalize(array $array): array
    {
        $returnArray = [];
        foreach ($array as $key => $value) {
            $returnArray[ucfirst($key)] = $value;
        }

        return $returnArray;
    }

    /**
     * Remove an element from an array
     *
     * @param array $array
     * @param $key
     */
    public static function remove(array &$array, $key): void
    {
        if (self::keyExists($key, $array)) {
            unset($array[$key]);
        }
    }

    /**
     * Remove the values of the $array parameters that are into the $valuesToRemove parameter too.
     * If the $strict parameter is false, the the type won't be checked.
     *
     * @param array $array
     * @param array $valuesToRemove
     * @param bool $strict
     *
     * @return array
     */
    public static function removeValues(array $array, array $valuesToRemove, bool $strict = false): array
    {
        if ($strict === true) {
            return array_diff($array, $valuesToRemove);
        }

        foreach ($array as $key => $value) {
            if (self::exists($value, $valuesToRemove)) {
                self::remove($array, $key);
            }
        }

        return $array;
    }

    /**
     * Remove elements of the $array parameter that correspond to the keys passed into $keysToRemove argument.
     * The $caseSensitive parameter will check or not if the keys are stricly same written.
     *
     * @param array $array
     * @param array $keysToRemove
     * @param bool $caseSensitive
     *
     * @return array
     */
    public static function removeKeys(array $array, array $keysToRemove, bool $caseSensitive = true): array
    {
        $keys = array_fill_keys($keysToRemove, 'REDLab');

        if ($caseSensitive === false) {
            $keys = self::keysLower($keys);
            $array = self::keysLower($array);
        }

        return array_diff_key($array, $keys);
    }
}