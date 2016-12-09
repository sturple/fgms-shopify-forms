<?php

namespace Fgms\EmailInquiriesBundle\Json;

class ValueWrapper extends \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl
{
    private $json;

    public function __construct($obj, $json, $path = '')
    {
        parent::__construct($obj,$path);
        $this->json = $json;
    }

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

    public function wrapImpl($key, $value)
    {
        return new self($value,$this->json,$this->join($key));
    }
}
