<?php

namespace Redlab\Exception;

/**
 * Class JsonException
 *
 * @author Jean-Baptiste MOTTO <motto@redlab.io>
 */
class JsonException extends \Exception
{
    /**
     * @var int
     */
    const UNKNOWN_ERROR = 899;

    /**
     * JsonException constructor.
     * @param int $code
     */
    public function __construct(int $code = 0, $message = null)
    {
        $message = $message ?? self::getErrorMessage($code);

        parent::__construct($message, $code);
    }

    /**
     * @param int $code
     * @return string
     */
    public static function getErrorMessage(int $code): string
    {
        $errors = [
            JSON_ERROR_NONE => 'No JSON error',
            JSON_ERROR_DEPTH => 'JSON Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR => 'JSON Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX => 'JSON Syntax error',
            JSON_ERROR_UTF8 => 'JSON Malformed UTF-8 characters, possibly incorrectly encoded',
            self::UNKNOWN_ERROR => 'Unknown JSON error'
        ];

        return array_key_exists($code, $errors) ? $errors[$code] : $errors[self::UNKNOWN_ERROR];
    }
}