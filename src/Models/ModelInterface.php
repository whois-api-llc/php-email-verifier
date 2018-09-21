<?php

namespace WhoisApi\EmailVerifier\Models;


/**
 * Interface ModelInterface
 * @package WhoisApi\EmailVerifier\Models
 */
interface ModelInterface
{
    /**
     * @param array $data
     */
    public function parse(array $data);
}