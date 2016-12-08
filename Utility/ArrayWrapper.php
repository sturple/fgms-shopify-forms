<?php

namespace Fgms\EmailInquiriesBundle\Utility;

/**
 * Represents an array obtained from an untrusted source
 * providing a convenient and safe way to interact with
 * the otherwise unsafe data.
 */
abstract class ArrayWrapper extends ValueWrapper implements \ArrayAccess, \IteratorAggregate, \Countable
{
    private $arr;

    public function __construct(array $arr, $path = '')
    {
        parent::__construct($path);
        $this->arr = $arr;
    }

    public function count()
    {
        return count($this->arr);
    }

    public function getIterator()
    {
        foreach ($this->arr as $key => $value) yield $key => $this->wrap($key,$value);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset,$this->arr);
    }

    public function offsetGet($offset)
    {
        return $this->wrap($offset,$this->arr[$offset]);
    }

    private function raiseImmutable()
    {
        throw new \LogicException('Shopify API arrays are immutable');
    }

    public function offsetSet($offset, $value)
    {
        $this->raiseImmutable();
    }

    public function offsetUnset($offset)
    {
        $this->raiseImmutable();
    }

    protected function check($key, array $types)
    {
        return $this->offsetExists($key);
    }

    protected function get($key, array $types)
    {
        if (!$this->offsetExists($key)) return null;
        return $this->arr[$key];
    }

    public function unwrap()
    {
        return $this->arr;
    }
}
