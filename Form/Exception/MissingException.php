<?php

namespace Fgms\EmailInquiriesBundle\Form\Exception;

/**
 * Thrown when the request object is missing an
 * expected property.
 */
class MissingException extends DataException
{
    /**
     * Creates a new MissingException.
     *
     * @param string $path
     *	The path at which a value was expected.
     * @param $prev
     *  The exception thrown by the underlying ValueWrapper.
     */
    public function __construct($path, $prev)
    {
        parent::__construct(
            sprintf(
                'Expected "%s"',
                $path
            ),
            0,
            $prev
        );
    }
}
