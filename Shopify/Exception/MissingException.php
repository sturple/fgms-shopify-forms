<?php

namespace Fgms\EmailInquiriesBundle\Shopify\Exception;

/**
 * Thrown when data returned by the Shopify API
 * is missing expected data.
 */
class MissingException extends DataException
{
    /**
     * Creates a new MissingException.
     *
     * @param string $path
     *  The JSON Pointer path to the expected data.
     * @param $prev
     *  The inner exception which caused this exception
     *  to be thrown.
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
