<?php

namespace Fgms\EmailInquiriesBundle\Json;

class ArrayWrapper extends \Fgms\EmailInquiriesBundle\Utility\ArrayWrapper
{
    use Wrapper;

    public function __construct(array $arr, $json, $path = '')
    {
        parent::__construct($arr,$path);
        $this->json = $json;
    }
}
