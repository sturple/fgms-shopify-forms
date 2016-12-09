<?php

namespace Fgms\EmailInquiriesBundle\Yaml;

class ObjectWrapper extends \Fgms\EmailInquiriesBundle\Utility\ObjectWrapper
{
    use Wrapper;

    public function __construct($obj, $yaml, $path = '')
    {
        parent::__construct($obj,$path);
        $this->yaml = $yaml;
    }
}
