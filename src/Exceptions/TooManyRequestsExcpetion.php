<?php


namespace WhoisApi\EmailVerifier\Exceptions;


/**
 * Class TooManyRequestsExcpetion
 * @package WhoisApi\EmailVerifier\Exceptions
 */
class TooManyRequestsExcpetion extends \Exception
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
            $message = 'You are limited to 10 queries per second. The request is rejected.';
        if ($code === 0)
            $code = 429;

        parent::__construct($message, $code, $previous);
    }
}