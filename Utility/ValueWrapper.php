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
     * Checks to see if there's a value (including null)
     * associated with a key.
     *
     * @param string|int $key
     * @param array $types
     *  The types being retrieved.
     *
     * @return bool
     */
    protected abstract function check($key, array $types);

    /**
     * Retrieves the value associated with a key, or
     * null if there is no such value.
     *
     * @param string|int $key
     * @param array $types
     *  The types being retrieved.
     *
     * @return mixed|null
     */
    protected abstract function get($key, array $types);

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
     * integer argument: The key whose value shall be
     * retrieved.
     */
    public function __call($name, array $arguments)
    {
        if (count($arguments) !== 1) throw new \BadMethodCallException(
            'get[Optional]<types> accepts exactly one string or integer argument'
        );
        return self::__callStatic($name,array_merge($arguments,[$this]));
    }

    private static function isOptional($str)
    {
        return !!preg_match('/^getOptional/u',$str);
    }

    private static function getTypes($str)
    {
        $num = preg_match_all('/(?:^get(?:Optional)?|(?<!^)\\G)([[:upper:]][[:lower:]]*)(?:Or(?!$)|$)/u',$str,$matches);
        if ($num === 0) throw new \BadMethodCallException('No types');
        return array_map(function ($type) {
            $type = strtolower($type);
            if ($type === 'boolean') $type = 'bool';
            if ($type === 'integer') $type = 'int';
            return $type;
        },$matches[1]);
    }

    private static function isType($val, $type)
    {
        $func = 'is_' . $type;
        if (!is_callable($func)) throw new \BadMethodCallException(
            sprintf(
                '"%s" is not a recognized type',
                $type
            )
        );
        return call_user_func($func,$val);
    }

    public static function __callStatic($name, array $arguments)
    {
        if (
            (count($arguments) < 2) ||
            !(
                is_string($arguments[0]) ||
                is_integer($arguments[0])
            )
        ) throw new \BadMethodCallException(
            'get[Optional]<types> accepts at least one string or integer argument followed by at least one ' . self::class . ' argument'
        );
        $opt = self::isOptional($name);
        $types = self::getTypes($name);
        $key = array_shift($arguments);
        foreach ($arguments as $wrapper) if (!($wrapper instanceof self)) throw new \BadMethodCallException(
            'All arguments beyond the first must be instance of ' . self::class
        );
        foreach ($arguments as $wrapper) {
            if (!$wrapper->check($key,$types)) continue;
            $val = $wrapper->get($key,$types);
            foreach ($types as $type) {
                if (self::isType($val,$type)) return $wrapper->wrap($key,$val);
            }
            $wrapper->raiseTypeMismatch($key,implode('|',$types),$val);
            throw new \LogicException('raiseTypeMismatch did not throw');
        }
        if ($opt) return null;
        $arguments[count($arguments) - 1]->raiseMissing($key);
        throw new \LogicException('raiseMissing did not throw');
    }
}
