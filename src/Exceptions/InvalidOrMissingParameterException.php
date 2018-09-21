<?php

namespace WhoisApi\EmailVerifier\Exceptions;

use Throwable;


/**
 * Class InvalidOrMissingParameterException
 * @package WhoisApi\EmailVerifier\Exceptions
 */
class InvalidOrMissingParameterException extends \Exception
{
    /**
     * InvalidOrMissingParameterException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'Invalid or missing parameter';
        if ($code === 0)
            $code = 400;

        parent::__construct($message, $code, $previous);
    }
}