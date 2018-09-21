<?php


namespace WhoisApi\EmailVerifier\Builders;


/**
 * Interface ResponseModelBuilderInterface
 * @package WhoisApi\EmailVerifier\Builders
 */
interface ResponseModelBuilderInterface
{
    /**
     * @param string $jsonData
     * @return \WhoisApi\EmailVerifier\Models\Response
     * @throws \WhoisApi\EmailVerifier\Exceptions\UnparsableResponseException
     */
    public function build($jsonData = '');
}