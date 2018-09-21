<?php

use PHPUnit\Framework\TestCase;
use WhoisApi\EmailVerifier\Clients\GuzzleClient;
use WhoisApi\EmailVerifier\Exceptions\AccessDeniedException;
use WhoisApi\EmailVerifier\Exceptions\InvalidOrMissingParameterException;
use WhoisApi\EmailVerifier\Exceptions\ServerErrorException;
use WhoisApi\EmailVerifier\Exceptions\TooManyRequestsExcpetion;


/**
 * Class RequestTest
 */
class RequestTest extends TestCase
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
     *
     */
    public function testRequest200Code()
    {
        $stream = $this->getMockBuilder(\GuzzleHttp\Psr7\Stream::class)
            ->disableOriginalConstructor()
            ->setMethods(['close', '__toString'])
            ->getMock();

        $stream->method('close')
            ->willReturn('');
        $stream->method('__toString')
            ->willReturn($this->sampleJson);

        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getReasonPhrase')
            ->willReturn('OK');
        $response->method('getBody')
            ->willReturn($stream);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->assertEquals(
            $this->sampleJson,
            $client->request('https://test.test', 'get', [], [])
        );
    }

    /**
     *
     */
    public function testRequest199Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(199);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest300Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(300);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest404Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(404);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest500Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(500);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest400Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(400);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(InvalidOrMissingParameterException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest403Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(403);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(AccessDeniedException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest429Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(429);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        /**
         * @var GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject $request
         */
        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(TooManyRequestsExcpetion::class);
        $client->request('', '', [], []);
    }
}