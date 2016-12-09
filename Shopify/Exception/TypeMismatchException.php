<?php

namespace Fgms\EmailInquiriesBundle\Shopify\Exception;

/**
 * Thrown when data returned by the Shopify API is of
 * an unexpected type.
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
     *  The JSON Pointer path to the data.
     * @param $prev
     *  The inner exception which caused this exception
     *  to be thrown.
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
