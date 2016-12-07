<?php

namespace Fgms\EmailInquiriesBundle\Json;

class ObjectWrapper extends \Fgms\EmailInquiriesBundle\Utility\ObjectWrapper
{
    use Wrapper;

    public function __construct($obj, $json, $path = '')
    {
        parent::__construct($obj,$path);
        $this->json = $json;
    }
}
