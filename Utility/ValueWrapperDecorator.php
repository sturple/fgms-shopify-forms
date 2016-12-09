<?php

namespace Fgms\EmailInquiriesBundle\Utility;

/**
 * A convenience base class for implementing decorators
 * for @ref ValueWrapper objects.
 */
class ValueWrapperDecorator extends ValueWrapper
{
    private $inner;

    /**
     * Creates a new ValueWrapperDecorator which decorates
     * a certain @ref ValueWrapper.
     *
     * @param ValueWrapper $inner
     */
    public function __construct(ValueWrapper $inner)
    {
        $this->inner = $inner;
    }

    public function getPath()
    {
        return $this->inner->getPath();
    }

    public function unwrap()
    {
        return $this->inner->unwrap();
    }

    public function raiseMissing($key)
    {
        return $this->inner->raiseMissing($key);
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        return $this->inner->raiseTypeMismatch($key,$expected,$actual);
    }

    public function check($key, array $types = null)
    {
        return $this->inner->check($key,$types);
    }

    public function get($key, array $types = null)
    {
        return $this->inner->get($key,$types);
    }

    public function wrapImpl($key, $value)
    {
        return $this->inner->wrapImpl($key,$value);
    }

    public function getIterator()
    {
        return $this->inner->getIterator();
    }

    public function count()
    {
        return $this->inner->count();
    }

    /**
     * Retrieves the decorated @ref ValueWrapper object.
     *
     * @return ValueWrapper
     */
    protected function getInner()
    {
        return $this->inner;
    }
}
