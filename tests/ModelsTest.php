<?php

use PHPUnit\Framework\TestCase;
use WhoisApi\EmailVerifier\Models\Audit;
use WhoisApi\EmailVerifier\Models\Response;


/**
 * Class ModelsTest
 */
class ModelsTest extends TestCase
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
     * @var array
     */
    protected $sampleData = [];

    /**
     * @var
     */
    protected $sampleAuditModel;


    /**
     * @var
     */
    protected $sampleResponseModel;

    /**
     *
     */
    public function setUp()
    {
        $this->sampleData = json_decode($this->sampleJson, true);

        $auditModel = new Audit();
        $auditModel->auditUpdatedDate = \Carbon\Carbon::parse('2018-04-19 18:12:45.000 UTC');
        $auditModel->auditCreatedDate = \Carbon\Carbon::parse('2018-04-19 18:12:45.000 UTC');

        $this->sampleAuditModel = $auditModel;

        $responseModel = new Response(
            [],
            $this->sampleAuditModel
        );

        $this->sampleResponseModel = $responseModel;
        $this->sampleResponseModel->emailAddress = 'support@whoisxmlapi.com';
        $this->sampleResponseModel->formatCheck = true;
        $this->sampleResponseModel->dnsCheck = true;
        $this->sampleResponseModel->smtpCheck = true;
        $this->sampleResponseModel->freeCheck = false;
        $this->sampleResponseModel->disposableCheck = false;
        $this->sampleResponseModel->catchAllCheck = true;
        $this->sampleResponseModel->mxRecords = [
            'ALT1.ASPMX.L.GOOGLE.com',
            'ALT2.ASPMX.L.GOOGLE.com',
            'ASPMX.L.GOOGLE.com',
            'ASPMX2.GOOGLEMAIL.com',
            'ASPMX3.GOOGLEMAIL.com',
            'mx.yandex.net',
        ];
    }

    /**
     *
     */
    public function testAuditModel()
    {
        $model = new Audit();

        $model->parse($this->sampleData['audit']);

        $this->assertEquals($this->sampleAuditModel, $model);
    }

    /**
     *
     */
    public function testResponseModel()
    {
        $model = new Response(
            $this->sampleData,
            new Audit()
        );

        $this->assertEquals($this->sampleResponseModel, $model);
    }
}