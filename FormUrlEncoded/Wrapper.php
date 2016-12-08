<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded;

trait Wrapper
{
    private $raw;

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

    public function wrapArray($key, array $value)
    {
        return new ArrayWrapper($value,$this->raw,$this->join($key));
    }

    public function wrapObject($key, $value)
    {
        return new ObjectWrapper($value,$this->raw,$this->join($key));
    }
}
