<?php

namespace Fgms\EmailInquiriesBundle\Form;

class ValueWrapper extends \Fgms\EmailInquiriesBundle\Utility\ValueWrapper
{
    use Wrapper;

    public function __construct(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $inner)
    {
        parent::__construct($inner->getPath());
        $this->inner = $inner;
    }
}
