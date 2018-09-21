<?php

namespace WhoisApi\EmailVerifier\Builders;


/**
 * Interface ClientBuilderInterface
 * @package WhoisApi\EmailVerifier\Builders
 */
interface ClientBuilderInterface
{
    /**
     * @param string $apiKey
     * @param string $url
     * @return \WhoisApi\EmailVerifier\ApiClient
     */
    public function build($apiKey, $url = '');
}