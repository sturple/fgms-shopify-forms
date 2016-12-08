<?php

namespace Fgms\EmailInquiriesBundle\Form\Exception;

/**
 * Indicates that requested datum was of an
 * unexpected type.
 */
class TypeMismatchException extends DataException
{
    /**
     * Creates a new TypeMismatchException.
     *
     * @param string $expected
     *  A string giving the expected type.
     * @param mixed $actual
     *  The actual value.
     * @param string $path
     *  The JSON Pointer path to the offending
	 *  value.
	 * @param $prev
	 *  The exception thrown by the underlying ValueWrapper.
     */
    public function __construct($expected, $actual, $path, $prev)
    {
        parent::__construct(
            sprintf(
                'Expected "%s" to be %s (got %s)',
                $path,
                $expected,
                gettype($actual)
            ),
			0,
			$prev
        );
    }
}
