<?php

namespace Fgms\EmailInquiriesBundle\Utility;

trait BasicWrapper
{
    public function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new \LogicException('Type mismatch');
    }

    public function raiseMissing($key)
    {
        throw new \LogicException('Missing');
    }
}
