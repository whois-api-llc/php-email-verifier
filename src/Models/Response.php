<?php

namespace WhoisApi\EmailVerifier\Models;


/**
 * Class ResponseModel
 * @package WhoisApi\EmailVerifier\Models
 */
class Response extends AbstractModel
{
    const AUDIT_KEY = 'audit';

    /**
     * @var
     */
    public $emailAddress;

    /**
     * @var
     */
    public $formatCheck;

    /**
     * @var
     */
    public $smtpCheck;

    /**
     * @var
     */
    public $dnsCheck;

    /**
     * @var
     */
    public $freeCheck;

    /**
     * @var
     */
    public $disposableCheck;

    /**
     * @var
     */
    public $catchAllCheck;

    /**
     * @var
     */
    public $mxRecords;

    /**
     * @var
     */
    public $audit;

    /**
     * @var ModelInterface
     */
    protected $auditModel;

    /**
     * Response constructor.
     * @param array $data
     * @param ModelInterface $audit
     */
    public function __construct(
        array $data,
        ModelInterface $audit
    )
    {
        $this->auditModel = $audit;

        if (count($data) > 0)
            $this->parse($data);
    }

    /**
     * @param array $data
     */
    protected function parseAssocArray(array $data)
    {
        parent::parseAssocArray($data);

        if (isset($data[static::AUDIT_KEY]))
            $this->audit = $this->auditModel->parse($data[static::AUDIT_KEY]);
    }
}