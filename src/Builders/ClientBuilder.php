<?php

namespace WhoisApi\EmailVerifier\Builders;


use GuzzleHttp\Client;
use WhoisApi\EmailVerifier\ApiClient;
use WhoisApi\EmailVerifier\Clients\GuzzleClient;

/**
 * Class ClientBuilder
 * @package WhoisApi\EmailVerifier\Builders
 */
class ClientBuilder implements ClientBuilderInterface
{

    /**
     * @param string $apiKey
     * @param string $url
     * @return ApiClient
     */
    public function build($apiKey, $url = '')
    {
        $builder = new ResponseModelBuilder('');
        $client = new GuzzleClient(new Client());

        return new ApiClient($client, $builder, $apiKey, $url);
    }
}