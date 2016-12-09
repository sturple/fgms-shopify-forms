<?php

namespace Fgms\EmailInquiriesBundle\Utility;

/**
 * Concretely realizes the @ref ValueWrapper class by
 * wrapping an array or object.
 */
class ValueWrapperImpl extends ValueWrapper
{
    private $wrapped;
    private $path;

    public function __construct($wrap, $path = '')
    {
        $this->wrapped = $wrap;
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new \LogicException('Type mismatch');
    }

    public function raiseMissing($key)
    {
        throw new \LogicException('Missing');
    }

    public function unwrap()
    {
        return $this->wrapped;
    }

    public function check($key, array $types = null)
    {
        if (is_object($this->wrapped)) return property_exists($this->wrapped,$key);
        return array_key_exists($key,$this->wrapped);
    }

    public function get($key, array $types = null)
    {
        if (!$this->check($key,$types)) return null;
        if (is_object($this->wrapped)) return $this->wrapped->$key;
        return $this->wrapped[$key];
    }

    public function getIterator()
    {
        foreach ($this->wrapped as $key => $value) yield $key => $this->wrap($key,$value);
    }

    public function count()
    {
        if (is_array($this->wrapped)) return count($this->wrapped);
        return count(get_object_vars($this->wrapped));
    }

    public function wrapImpl($key, $value)
    {
        return new self($value,$this->join($key));
    }
}
