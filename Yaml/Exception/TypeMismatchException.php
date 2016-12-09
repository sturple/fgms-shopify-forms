<?php

namespace Fgms\EmailInquiriesBundle\Yaml\Exception;

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
     * @param string $yaml
     *  The YAML string of the document in which
     *  the path is located.
     */
    public function __construct($expected, $actual, $path, $yaml)
    {
        parent::__construct(
            sprintf(
                'Expected "%s" to be %s (got %s): %s',
                $path,
                $expected,
                gettype($actual),
                $yaml
            )
        );
    }
}
