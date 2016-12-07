<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded;

trait Wrapper
{
    private $raw;

    protected function raiseMissing($key)
    {
        throw new Exception\MissingException(
            $this->join($key),
            $this->raw
        );
    }

    protected function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new Exception\TypeMismatchException(
            $expected,
            $actual,
            $this->join($key),
            $this->raw
        );
    }

    protected function wrapArray($key, array $value)
    {
        return new ArrayWrapper($value,$this->raw,$this->join($key));
    }

    protected function wrapObject($key, $value)
    {
        return new ObjectWrapper($value,$this->raw,$this->join($key));
    }
}
