<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded;

class ValueWrapper extends \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl
{
    private $raw;

    public function __construct($obj, $raw, $path = '')
    {
        parent::__construct($obj,$path);
        $this->raw = $raw;
    }

    public function raiseMissing($key)
    {
        throw new Exception\MissingException(
            $this->join($key),
            $this->raw
        );
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new Exception\TypeMismatchException(
            $expected,
            $actual,
            $this->join($key),
            $this->raw
        );
    }

    public function wrapImpl($key, $value)
    {
        return new self($value,$this->raw,$this->join($key));
    }
}
