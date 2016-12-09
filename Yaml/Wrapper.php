<?php

namespace Fgms\EmailInquiriesBundle\Yaml;

trait Wrapper
{
    private $yaml;

    public function raiseMissing($key)
    {
        throw new Exception\MissingException(
            $this->join($key),
            $this->yaml
        );
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new Exception\TypeMismatchException(
            $expected,
            $actual,
            $this->join($key),
            $this->yaml
        );
    }

    public function wrapArray($key, array $value)
    {
        return new ArrayWrapper($value,$this->yaml,$this->join($key));
    }

    public function wrapObject($key, $value)
    {
        return new ObjectWrapper($value,$this->yaml,$this->join($key));
    }
}
