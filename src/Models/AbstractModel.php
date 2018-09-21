<?php

namespace WhoisApi\EmailVerifier\Models;


/**
 * Class AbstractModel
 * @package WhoisApi\EmailVerifier\Models
 */
abstract class AbstractModel implements ModelInterface
{
    /**
     * @param array $data
     */
    public function parse(array $data)
    {
        $this->parseAssocArray($data);
    }

    /**
     * @param array $data
     */
    protected function parseAssocArray(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key))
                $this->{$key} = $this->convertTypes($value);
        }
    }

    /**
     * @param $value
     * @return bool|null
     */
    protected function convertTypes($value)
    {
        if ($value === 'true')
            return true;
        if ($value === 'false')
            return false;
        if ($value === 'null')
            return null;

        return $value;
    }
}