<?php

namespace WhoisApi\EmailVerifier;

use WhoisApi\EmailVerifier\Builders\ResponseModelBuilderInterface;
use WhoisApi\EmailVerifier\Clients\ClientInterface;
use WhoisApi\EmailVerifier\Exceptions\AccessDeniedException;
use WhoisApi\EmailVerifier\Exceptions\EmptyResponseException;
use WhoisApi\EmailVerifier\Exceptions\InvalidOrMissingParameterException;
use WhoisApi\EmailVerifier\Exceptions\ServerErrorException;
use WhoisApi\EmailVerifier\Exceptions\UnparsableResponseException;


/**
 * Class ApiClient
 * @package WhoisApi\EmailVerifier
 */
class ApiClient implements ApiClientInterface
{
    const API_BASE_URL = 'https://emailverification.whoisxmlapi.com/api/v1';
    const USER_AGENT_BASE = 'PHP Client library/';
    const VERSION = '1.0.0';

    const API_KEY_F = 'apiKey';
    const EMAIL_ADDRESS_F = 'emailAddress';
    const FORMAT_F = 'outputFormat';

    const DEFAULT_FORMAT_V = 'json';

    const REQUEST_METHOD = 'get';

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ResponseModelBuilderInterface
     */
    protected $builder;

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $parameters = [
        'validateDNS',
        'validateSMTP',
        'checkCatchAll',
        'checkFree',
        'checkDisposable',
        '_hardRefresh',
    ];

    /**
     * ApiClient constructor.
     * @param ClientInterface $client
     * @param ResponseModelBuilderInterface $builder
     * @param $apiKey
     * @param string $url
     */
    public function __construct(
        ClientInterface $client,
        ResponseModelBuilderInterface $builder,
        $apiKey,
        $url = ""
    )
    {
        $this->client = $client;
        $this->builder = $builder;
        $this->setApiKey($apiKey);

        if ($url === "") {
            $this->setBaseUrl(static::API_BASE_URL);
        } else {
            $this->setBaseUrl($url);
        }
    }

    /**
     * @param string $email
     * @param array $disabledParameters
     * @return Models\Response
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws AccessDeniedException
     * @throws InvalidOrMissingParameterException
     * @throws UnparsableResponseException
     */
    public function get($email, array $disabledParameters = [])
    {
        $payload = [
            static::API_KEY_F => $this->apiKey,
            static::EMAIL_ADDRESS_F => $email,
            static::FORMAT_F => static::DEFAULT_FORMAT_V,
        ];

        $payload += $this->buildExtraParams($disabledParameters);

        $response = $this->client->request(
            $this->url,
            static::REQUEST_METHOD,
            $payload,
            $this->buildCustomHeaders()
        );

        if (strlen($response) <= 0) {
            throw new EmptyResponseException();
        }

        return $this->builder->build($response);
    }

    /**
     * @param $email
     * @param string $format
     * @param array $disabledParameters
     * @return string
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws AccessDeniedException
     * @throws InvalidOrMissingParameterException
     * @throws UnparsableResponseException
     */
    public function getRawData($email, $format = null, array $disabledParameters = [])
    {
        $format = is_null($format) ? static::DEFAULT_FORMAT_V : $format;
        $payload = [
            static::API_KEY_F => $this->apiKey,
            static::EMAIL_ADDRESS_F => $email,
            static::FORMAT_F => $format,
        ];

        $payload += $this->buildExtraParams($disabledParameters);

        $response = $this->client->request(
            $this->url,
            static::REQUEST_METHOD,
            $payload,
            $this->buildCustomHeaders()
        );

        if (strlen($response) <= 0) {
            throw new EmptyResponseException();
        }

        return $response;
    }

    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        if (!empty($apiKey) && is_string($apiKey))
            $this->apiKey = $apiKey;
    }

    /**
     * @param $url
     */
    public function setBaseUrl($url)
    {
        if (!empty($url) && is_string($url))
            $this->url = $url;
    }

    /**
     * @return array
     */
    protected function buildCustomHeaders()
    {
        return [
            'User-Agent' => static::USER_AGENT_BASE . static::VERSION,
        ];
    }

    /**
     * @param array $disabled
     * @return array
     */
    protected function buildExtraParams(array $disabled)
    {
        $params = [];

        foreach ($this->parameters as $parameter) {
            if (in_array($parameter, $disabled)) {
                $params[$parameter] = 0;
            } else {
                $params[$parameter] = 1;
            }
        }

        return $params;
    }
}