<?php

namespace Fgms\EmailInquiriesBundle\Configuration;

class MockValueWrapperConfiguration extends ValueWrapperConfiguration
{
    public function __construct(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $wrapper = null)
    {
        if (!is_null($wrapper)) $this->setValueWrapper($wrapper);
    }

    public function load($str)
    {
        throw new \LogicException('Unimplemented');
    }
}
