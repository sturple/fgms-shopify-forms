<?php

namespace Fgms\EmailInquiriesBundle\Json;

trait Wrapper
{
    private $json;

    public function raiseMissing($key)
    {
        throw new Exception\MissingException(
            $this->join($key),
            $this->json
        );
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new Exception\TypeMismatchException(
            $expected,
            $actual,
            $this->join($key),
            $this->json
        );
    }

    public function wrapArray($key, array $value)
    {
        return new ArrayWrapper($value,$this->json,$this->join($key));
    }

    public function wrapObject($key, $value)
    {
        return new ObjectWrapper($value,$this->json,$this->join($key));
    }
}
