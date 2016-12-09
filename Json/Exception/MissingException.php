<?php

namespace Fgms\EmailInquiriesBundle\Json\Exception;

/**
 * Indicates that requested datum was missing.
 */
class MissingException extends DataException
{
    /**
     * Creates a new MissingException.
     *
     * @param string $path
     *  The JSON Pointer path to the expected datum.
     * @param string $json
     *  The JSON document in which the path should
     *  have been located.
     */
    public function __construct($path, $json)
    {
        parent::__construct(
            sprintf(
                'Expected "%s": %s',
                $path,
                $json
            )
        );
    }
}
