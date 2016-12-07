<?php

namespace Fgms\EmailInquiriesBundle\Utility;

/**
 * Represents an object obtained from an untrusted source
 * providing a convenient way to interact with the otherwise
 * unsafe data.
 */
abstract class ObjectWrapper extends ValueWrapper
{
    private $obj;

    public function __construct($obj, $path = '')
    {
        parent::__construct($path);
        $this->obj = $obj;
    }

    public function __isset($key)
    {
        return isset($this->obj->$key);
    }

    public function __get($key)
    {
        if (!isset($this->obj->$key)) return null;
        return $this->obj->$key;
    }
    
    protected function get($key)
    {
        //  Use property_exists rather than isset
        //  so we get true for properties which
        //  exist but which are set to null
        if (!property_exists($this->obj,$key)) $this->raiseMissing($key);
        return $this->obj->$key;
    }

    protected function getOptional($key)
    {
        if (!isset($this->obj->$key)) return null;
        return $this->obj->$key;
    }
}
