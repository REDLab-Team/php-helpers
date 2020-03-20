<?php

namespace RedlabTeam\Helper;

/**
 * This class contains methods to convert strings into json and reverse the dates in the application.
 *
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class Json
{
    /**
     * @var int
     */
    protected $lastErrorCode;

    /**
     * @var string
     */
    protected $lastErrorMessage;

    public function __construct()
    {
        $this->setLastError();
    }

    /**
     * This method is used to decode json format strings.
     * If the $string parameter is null then it will return a null value without trying to decode it.
     *
     * @param string $string
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     *
     * @return mixed
     */
    public function decode(?string $string, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        if ($string === null) {
            return null;
        }

        $newValue = json_decode($string, $assoc, $depth, $options) ?? ($assoc === false ? null : []);

        $this->setLastError();

        return $newValue;
    }

    /**
     * This method is used to encode any PHP variable to a json format string.
     * If there is an error, null value will be returned.
     *
     * @param $value
     * @param int $options
     * @param int $depth
     *
     * @return ?string
     */
    public function encode($value, int $options = 0, int $depth = 512): ?string
    {
        $newValue = json_encode($value, $options, $depth) ?? null;

        $this->setLastError();

        return $newValue;
    }

    /**
     * Set the last json error that would be returned by PHP. This error can be used to throw a JsonException.
     *
     * @return $this
     */
    protected function setLastError(): self
    {
        $this->lastErrorCode = json_last_error();
        $this->lastErrorMessage = json_last_error_msg();

        return $this;
    }

    /**
     * Return the last json error code that would be returned by PHP.
     *
     * @return int
     */
    public function getLastErrorCode(): int
    {
        return $this->lastErrorCode;
    }

    /**
     * Return the last json error message that would be returned by PHP.
     *
     * @return string
     */
    public function getLastErrorMessage(): string
    {
        return $this->lastErrorMessage;
    }

    /**
     * Return true if the last json function returns any error.
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->getLastErrorCode() !== 0;
    }
}