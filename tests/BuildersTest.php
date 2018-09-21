<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use WhoisApi\EmailVerifier\ApiClient;
use WhoisApi\EmailVerifier\Builders\ClientBuilder;
use WhoisApi\EmailVerifier\Builders\ResponseModelBuilder;
use WhoisApi\EmailVerifier\Clients\GuzzleClient;
use WhoisApi\EmailVerifier\Exceptions\UnparsableResponseException;
use WhoisApi\EmailVerifier\Models\Audit;
use WhoisApi\EmailVerifier\Models\Response;


/**
 * Class BuilderTest
 */
class BuilderTest extends TestCase
{
    /**
     * @var string
     */
    protected $sampleJson = <<<EOT
{
  "emailAddress": "support@whoisxmlapi.com",
  "formatCheck": "true",
  "smtpCheck": "true",
  "dnsCheck": "true",
  "freeCheck": "false",
  "disposableCheck": "false",
  "catchAllCheck": "true",
  "mxRecords": [
    "ALT1.ASPMX.L.GOOGLE.com",
    "ALT2.ASPMX.L.GOOGLE.com",
    "ASPMX.L.GOOGLE.com",
    "ASPMX2.GOOGLEMAIL.com",
    "ASPMX3.GOOGLEMAIL.com",
    "mx.yandex.net"
  ],
  "audit": {
    "auditCreatedDate": "2018-04-19 18:12:45.000 UTC",
    "auditUpdatedDate": "2018-04-19 18:12:45.000 UTC"
  }
}
EOT;

    /**
     * @var string
     */
    protected $apiKey = 'at_testkey';


    /**
     * @var string
     */
    protected $url = 'https://emailverification.whoisxmlapi.com/api/v1';


    /**
     *
     */
    public function testParsing()
    {
        $audit = new Audit();

        $responseModel = new Response(
            json_decode($this->sampleJson, true),
            $audit
        );

        $builder = new ResponseModelBuilder('');

        $this->assertEquals($responseModel, $builder->build($this->sampleJson));
    }

    /**
     *
     */
    public function testParsingFailure()
    {
        $builder = new ResponseModelBuilder('');

        $this->expectException(UnparsableResponseException::class);

        $builder->build('smth good');
    }

    /**
     *
     */
    public function testClientBuilder()
    {
        $builder = new ResponseModelBuilder('');
        $client = new GuzzleClient(new Client());

        $valid = new ApiClient($client, $builder, $this->apiKey, $this->url);

        $clientBuilder = new ClientBuilder();

        $test = $clientBuilder->build($this->apiKey, $this->url);

        $this->assertEquals($valid, $test);
    }
}