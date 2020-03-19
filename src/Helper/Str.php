<?php

namespace RedlabTeam\Helper;

class Str
{
    /**
     * Check if the value is scalar and if it contains only numbers and letters.
     *
     * @param $valueToTest
     *
     * @return bool
     */
    public static function isAlphaNumeric($value): bool
    {
        return is_scalar($value) && preg_match('/^[a-zA-Z0-9]+$/', $value) === 1;
    }

    /**
     * Check if the string $value parameter could be a boolean value.
     *
     * @param string $value
     * @param bool $strict
     *
     * @return bool
     */
    public static function isBool(string $value, bool $strict = true): bool
    {
        $boolValues = ['true', 'false', '1', '0'];

        $value = $strict === true ? strtolower($value) : $value;

        return Arr::exists($value, $boolValues);
    }
}