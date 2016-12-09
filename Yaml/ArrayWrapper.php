<?php

namespace Fgms\EmailInquiriesBundle\Yaml;

class ArrayWrapper extends \Fgms\EmailInquiriesBundle\Utility\ArrayWrapper
{
    use Wrapper;

    public function __construct(array $arr, $yaml, $path = '')
    {
        parent::__construct($arr,$path);
        $this->yaml = $yaml;
    }
}
