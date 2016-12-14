<?php

namespace Fgms\EmailInquiriesBundle\Form;

class ValueWrapper extends \Fgms\ValueWrapper\ValueWrapperDecorator
{
    public function raiseMissing($key)
    {
        try {
            $this->getInner()->raiseMissing($key);
        } catch (\Exception $ex) {
            throw new Exception\MissingException($key,$ex);
        }
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        try {
            $this->getInner()->raiseTypeMismatch($key,$expected,$actual);
        } catch (\Exception $ex) {
            throw new Exception\TypeMismatchException($key,$expected,$actual,$ex);
        }
    }

    public function wrapImpl($key, $value)
    {
        return new self($this->inner->wrapImpl($key,$value));
    }
}
