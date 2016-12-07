<?php

namespace Fgms\EmailInquiriesBundle\Utility;

/**
 * A base class for safe wrappers for arrays and
 * objects returned from untrusted sources.
 */
abstract class ValueWrapper
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

	/**
	 * Joins a string or integer key with the current path.
	 *
	 * @param string|int $key
	 *
	 * @return string
	 */
    public function join($key)
    {
        //  TODO: JSON Pointer escaping
        return $this->path . '/' . $key;
    }

	/**
	 * Returns the underlying value.
	 *
	 * @return array|object
	 */
	public abstract function unwrap();

    /**
     * Called to raise an exception indicating that a certain
	 * string or integer key is not present.
     *
     * @param string|int $key
     */
    protected abstract function raiseMissing($key);

	/**
	 * Called to raise an exception indicating that a certain
	 * string or integer key has an unexpected type.
	 *
	 * @param string|int $key
	 * @param string $expected
	 * @param mixed $actual
	 */
	protected abstract function raiseTypeMismatch($key, $expected, $actual);

    /**
     * Retrieves the value associated with a key.
     *
     * @param string|int $key
     *
     * @return mixed
     */
    protected abstract function get($key);

    /**
     * Retrieves the value associated with a key, or
     * null if there is no such value.
     *
     * @param string|int $key
     *
     * @return mixed|null
     */
    protected abstract function getOptional($key);

	/**
	 * Wraps an array in an ArrayWrapper.
	 *
	 * @param string|int $key
	 *
	 * @return ArrayWrapper
	 */
	protected function wrapArray($key, array $value)
	{
		return new BasicArrayWrapper($value,$this->join($key));
	}

	/**
	 * Wraps an object in an ObjectWrapper.
	 *
	 * @param string|int $key
	 *
	 * @return ObjectWrapper
	 */
	protected function wrapObject($key, $value)
	{
		return new BasicObjectWrapper($value,$this->join($key));
	}

    /**
     * Wraps a value in an ObjectWrapper or ArrayWrapper,
     * or returns it unmodified as appropriate.
     *
     * @param string|int $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function wrap($key, $value)
    {
        if (is_object($value)) return $this->wrapObject($key,$value);
        if (is_array($value)) return $this->wrapArray($key,$value);
        return $value;
    }

    /**
     * Allows getType methods to be invoked on object's
     * of this type, where Type is string, integer,
     * float/double, bool/boolean, object, array, or null.
     *
     * Additionally getOptionalType methods may be invoked
     * which may return null.
     *
     * These methods all accept exactly one string or
     * integer argument: The key whole value shall be
     * retrieved.
     */
    public function __call($name, array $arguments)
    {
        if (
            (count($arguments) !== 1) ||
            !(
                is_string($arguments[0]) ||
                is_integer($arguments[0])
            )
        ) throw new \BadMethodCallException(
            'get[Optional]<type> accepts exactly one string or integer argument'
        );
        $str = preg_replace('/^get/u','',$name,-1,$count);
        if ($count === 0) throw new \BadMethodCallException(
            sprintf('"%s" is not a valid get[Optional]<type> method',$name)
        );
        $str = preg_replace('/^Optional/u','',$str,-1,$count);
        $opt = $count !== 0;
        $type = strtolower($str);
        //  There is no is_boolean
        if ($type === 'boolean') $type = 'bool';
        $key = $arguments[0];
        if ($opt) {
            $val = $this->getOptional($key);
            if (is_null($val)) return null;
        } else {
            $val = $this->get($key);
        }
        $func = 'is_' . $type;
        if (!is_callable($func)) throw new \BadMethodCallException(
            sprintf(
                '"%s" is not a recognized type',
                $type
            )
        );
        if (!call_user_func($func,$val)) $this->raiseTypeMismatch($key,$type,$val);
        return $this->wrap($key,$val);
    }
}
