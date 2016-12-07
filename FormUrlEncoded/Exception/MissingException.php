<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded\Exception;

/**
 * Indicates that requestd datum was missing.
 */
class MissingException extends DataException
{
    /**
     * Creates a new MissingException.
     *
     * @param string $path
     *  The path to the expected datum.
     * @param string $raw
     *  The form URL encoded string in which the
     *  path should have been located.
     */
    public function __construct($path, $raw)
    {
        parent::__construct(
            sprintf(
                'Expected "%s": %s',
                $path,
                $raw
            )
        );
    }
}
