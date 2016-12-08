<?php

namespace Fgms\EmailInquiriesBundle\Form;

class ArrayWrapper extends \Fgms\EmailInquiriesBundle\Utility\ArrayWrapper
{
    use Wrapper;

    public function __construct(\Fgms\EmailInquiriesBundle\Utility\ArrayWrapper $inner)
    {
        parent::__construct($inner->unwrap(),$inner->getPath());
        $this->inner = $inner;
    }
}
