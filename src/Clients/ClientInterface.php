<?php

namespace WhoisApi\EmailVerifier\Clients;

use WhoisApi\EmailVerifier\Exceptions\AccessDeniedException;
use WhoisApi\EmailVerifier\Exceptions\InvalidOrMissingParameterException;
use WhoisApi\EmailVerifier\Exceptions\ServerErrorException;


/**
 * Interface ClientInterface
 * @package WhoisApi\EmailVerifier\Clients
 */
interface ClientInterface
{
    /**
     * @param $url
     * @param $method
     * @param array $payload
     * @param array $headers
     * @return string
     * @throws ServerErrorException
     * @throws AccessDeniedException
     * @throws InvalidOrMissingParameterException
     */
    public function request($url, $method, array $payload, array $headers);
}