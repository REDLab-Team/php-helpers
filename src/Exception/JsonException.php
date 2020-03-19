<?php

namespace RedlabTeam\Exception;

use RedlabTeam\Helper\Arr;

/**
 * Class JsonException
 *
 * @author Jean-Baptiste MOTTO <motto@redlab.io>
 */
class JsonException extends \Exception
{
    /**
     * JsonException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}