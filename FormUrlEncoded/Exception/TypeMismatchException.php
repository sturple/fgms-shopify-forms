<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded\Exception;

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
     *  The path to the datum.
     * @param string $raw
     *  The raw form URL encoded string of the data in
     *  which the path is located.
     */
    public function __construct($expected, $actual, $path, $raw)
    {
        parent::__construct(
            sprintf(
                'Expected "%s" to be %s (got %s): %s',
                $path,
                $expected,
                gettype($actual),
                $raw
            )
        );
    }
}
