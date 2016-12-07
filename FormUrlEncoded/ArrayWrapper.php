<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded;

class ArrayWrapper extends \Fgms\EmailInquiriesBundle\Utility\ArrayWrapper
{
    use Wrapper;

    public function __construct(array $arr, $raw, $path = '')
    {
        parent::__construct($arr,$path);
        $this->raw = $raw;
    }
}
