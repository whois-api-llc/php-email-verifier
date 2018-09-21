<?php

namespace WhoisApi\EmailVerifier\Exceptions;

use Throwable;


/**
 * Class AccessDeniedException
 * @package WhoisApi\EmailVerifier\Exceptions
 */
class AccessDeniedException extends \Exception
{
    /**
     * AccessDeniedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'Access restricted';
        if ($code === 0)
            $code = 403;

        parent::__construct($message, $code, $previous);
    }
}