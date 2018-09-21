<?php

namespace WhoisApi\EmailVerifier;

use WhoisApi\EmailVerifier\Exceptions\AccessDeniedException;
use WhoisApi\EmailVerifier\Exceptions\EmptyResponseException;
use WhoisApi\EmailVerifier\Exceptions\InvalidOrMissingParameterException;
use WhoisApi\EmailVerifier\Exceptions\ServerErrorException;
use WhoisApi\EmailVerifier\Exceptions\UnparsableResponseException;

/**
 * Interface ApiClientInterface
 */
interface ApiClientInterface
{
    /**
     * @param string $url Base API URl
     */
    public function setBaseUrl($url);

    /**
     * @param string $apiKey Your API key
     */
    public function setApiKey($apiKey);

    /**
     * @param string $email
     * @param array $disabledParameters
     * @return \WhoisApi\EmailVerifier\Models\Response
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws AccessDeniedException
     * @throws InvalidOrMissingParameterException
     * @throws UnparsableResponseException
     */
    public function get($email, array $disabledParameters = []);

    /**
     * @param string $ip
     * @param string $format Supported formats json/xml
     * @param array $disabledParameters
     * @return string
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws AccessDeniedException
     * @throws InvalidOrMissingParameterException
     * @throws UnparsableResponseException
     */
    public function getRawData($ip, $format = null, array $disabledParameters = []);
}