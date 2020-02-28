<?php

namespace Redlab\Helper;

use Redlab\Exception\JsonException;

/**
 * This class contains methods to convert strings into json and reverse the dates in the application.
 *
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class Json
{
    /**
     * @var int|null
     */
    protected $lastError;

    /**
     * @param string $string
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     *
     * @return mixed
     */
    public function decode(?string $string, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        $newValue = json_decode($string, $assoc, $depth, $options) ?? ($assoc === false ? null : []);

        $this->setLastError();

        return $newValue;
    }

    /**
     * @param $value
     * @param int $options
     * @param int $depth
     *
     * @return string
     */
    public function encode($value, int $options = 0, int $depth = 512): string
    {
        $newValue = json_encode($value, $options, $depth) ?? null;

        $this->setLastError();

        return $newValue;
    }

    /**
     * Set the last json error that would be returned by PHP. This error can be used to throw a JsonException
     *
     * @return $this
     */
    private function setLastError(): self
    {
        $this->lastError = json_last_error();

        return $this;
    }

    /**
     * Return the last json error that would be returned by PHP
     *
     * @return int
     */
    public function getLastErrorCode(): int
    {
        return $this->lastError;
    }
}