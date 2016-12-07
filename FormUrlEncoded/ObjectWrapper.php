<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded;

class ObjectWrapper extends \Fgms\EmailInquiriesBundle\Utility\ObjectWrapper
{
    use Wrapper;

    public function __construct($obj, $raw, $path = '')
    {
        parent::__construct($obj,$path);
        $this->raw = $raw;
    }
}
