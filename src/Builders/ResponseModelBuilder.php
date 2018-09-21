<?php

namespace WhoisApi\EmailVerifier\Builders;

use WhoisApi\EmailVerifier\Exceptions\UnparsableResponseException;
use WhoisApi\EmailVerifier\Models\Audit;
use WhoisApi\EmailVerifier\Models\Response;

/**
 * Class ResponseModelBuilder
 * @package WhoisApi\EmailVerifier\Builders
 */
class ResponseModelBuilder implements ResponseModelBuilderInterface
{
    /**
     * @var
     */
    protected $jsonData;

    /**
     * ResponseModelBuilder constructor.
     * @param $jsonData
     */
    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }

    /**
     * @param string $jsonData
     * @return Response
     */
    public function build($jsonData = '')
    {
        if (strlen($jsonData) <= 0)
            $jsonData = $this->jsonData;

        $audit = new Audit();

        $responseModel = new Response(
            $this->parseJson($jsonData),
            $audit
        );

        return $responseModel;
    }

    /**
     * @param $json
     * @return mixed
     * @throws UnparsableResponseException
     */
    protected function parseJson($json)
    {
        $parsed = json_decode($json, true);

        if (is_null($parsed) || $parsed === false) {
            throw new UnparsableResponseException();
        }

        return $parsed;
    }
}