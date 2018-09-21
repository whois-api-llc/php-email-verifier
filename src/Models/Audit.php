<?php


namespace WhoisApi\EmailVerifier\Models;

use Carbon\Carbon;

/**
 * Class Audit
 * @package WhoisApi\EmailVerifier\Models
 */
class Audit extends AbstractModel
{

    /**
     * @var
     */
    public $auditCreatedDate;

    /**
     * @var
     */
    public $auditUpdatedDate;

    /**
     * @param array $data
     */
    protected function parseAssocArray(array $data)
    {
        parent::parseAssocArray($data);

        $this->auditCreatedDate = empty($this->auditCreatedDate)
            ? null : Carbon::parse($this->auditCreatedDate);

        $this->auditUpdatedDate = empty($this->auditUpdatedDate)
            ? null : Carbon::parse($this->auditUpdatedDate);
    }
}