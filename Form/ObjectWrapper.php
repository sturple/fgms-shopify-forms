<?php

namespace Fgms\EmailInquiriesBundle\Form;

class ObjectWrapper extends \Fgms\EmailInquiriesBundle\Utility\ObjectWrapper
{
    use Wrapper;

    public function __construct(\Fgms\EmailInquiriesBundle\Utility\ObjectWrapper $inner)
    {
        parent::__construct($inner->unwrap(),$inner->getPath());
        $this->inner = $inner;
    }
}
