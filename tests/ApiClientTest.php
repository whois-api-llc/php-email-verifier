<?php

use PHPUnit\Framework\TestCase;
use WhoisApi\EmailVerifier\ApiClient;
use WhoisApi\EmailVerifier\Builders\ResponseModelBuilder;
use WhoisApi\EmailVerifier\Clients\GuzzleClient;
use WhoisApi\EmailVerifier\Exceptions\EmptyResponseException;


/**
 * Class ApiClientTest
 */
class ApiClientTest extends TestCase
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

    protected $sampleJsonWithoutSMTP = <<<EOT
{
  "emailAddress": "support@whoisxmlapi.com",
  "formatCheck": "true",
  "smtpCheck": "null",
  "dnsCheck": "true",
  "freeCheck": "false",
  "disposableCheck": "false",
  "catchAllCheck": "true",
  "mxRecords": [],
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
    protected $urlStub = 'https://emailverification.whoisxmlapi.com/api/v1337';

    protected $correctUrl = 'https://emailverification.whoisxmlapi.com/api/v1';

    protected $expectedParams = [
        'apiKey' => 'at_testkey',
        'outputFormat' => 'json',
        'emailAddress' => 'support@whoisxmlapi.com',
        'validateDns' => 1,
        'validateSMTP' => 1,
        'checkCatchAll' => 1,
        'checkFree' => 1,
        'checkDisposable' => 1,
        '_hardRefresh' => 1,
    ];

    protected $expectedHeaders = [
        'User-Agent' => 'PHP Client library/1.0.0'
    ];

    protected $email = 'support@whoisxmlapi.com';

    /**
     *
     */
    public function testGetMethod()
    {
        /**
         * @var \WhoisApi\EmailVerifier\Clients\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($this->correctUrl),
                $this->equalTo('get'),
                $this->equalTo($this->expectedParams),
                $this->equalTo($this->expectedHeaders)
            )
            ->willReturn($this->sampleJson);

        $builder = new ResponseModelBuilder('');

        $builderValid = new ResponseModelBuilder($this->sampleJson);

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->assertEquals($builderValid->build(), $client->get($this->email));
    }

    public function testGetMethodWithDisabledParam()
    {
        /**
         * @var \WhoisApi\EmailVerifier\Clients\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $params = $this->expectedParams;
        $params['validateSMTP'] = 0;
        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($this->correctUrl),
                $this->equalTo('get'),
                $this->equalTo($params),
                $this->equalTo($this->expectedHeaders)
            )
            ->willReturn($this->sampleJsonWithoutSMTP);

        $builder = new ResponseModelBuilder('');

        $builderValid = new ResponseModelBuilder($this->sampleJsonWithoutSMTP);

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->assertEquals($builderValid->build(), $client->get(
            $this->email,
            ['validateSMTP']
        ));
    }

    /**
     *
     */
    public function testGetMethodEmptyResponse()
    {
        /**
         * @var \WhoisApi\EmailVerifier\Clients\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($this->correctUrl),
                $this->equalTo('get'),
                $this->equalTo($this->expectedParams),
                $this->equalTo($this->expectedHeaders)
            )
            ->willReturn('');

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->expectException(EmptyResponseException::class);

        $client->get($this->email);
    }


    /**
     *
     */
    public function testGetRawDataMethod()
    {
        /**
         * @var \WhoisApi\EmailVerifier\Clients\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($this->correctUrl),
                $this->equalTo('get'),
                $this->equalTo($this->expectedParams),
                $this->equalTo($this->expectedHeaders)
            )
            ->willReturn($this->sampleJson);

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->assertEquals(
            $this->sampleJson,
            $client->getRawData($this->email, 'json')
        );
    }

    /**
     *
     */
    public function testGetRawDataMethodEmptyResponse()
    {
        /**
         * @var \WhoisApi\EmailVerifier\Clients\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($this->correctUrl),
                $this->equalTo('get'),
                $this->equalTo($this->expectedParams),
                $this->equalTo($this->expectedHeaders)
            )
            ->willReturn('');

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->expectException(EmptyResponseException::class);

        $client->getRawData($this->email, 'json');
    }

    /**
     *
     */
    public function testApiClientCustomUrl()
    {
        /**
         * @var \WhoisApi\EmailVerifier\Clients\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($this->urlStub),
                $this->equalTo('get'),
                $this->equalTo($this->expectedParams),
                $this->equalTo($this->expectedHeaders)
            )
            ->willReturn($this->sampleJson);

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient(
            $requestMock,
            $builder,
            $this->apiKey,
            $this->urlStub
        );

        $this->assertEquals(
            $this->sampleJson,
            $client->getRawData($this->email, 'json')
        );
    }
}