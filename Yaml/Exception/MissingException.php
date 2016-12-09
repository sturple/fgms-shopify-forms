<?php

namespace Fgms\EmailInquiriesBundle\Yaml\Exception;

/**
 * Indicates that requested datum was missing.
 */
class MissingException extends DataException
{
    /**
     * Creates a new MissingException.
     *
     * @param string $path
     *  The path to the expected datum.
     * @param string $yaml
     *  The YAML document in which the path should
     *  have been located.
     */
    public function __construct($path, $yaml)
    {
        parent::__construct(
            sprintf(
                'Expected "%s": %s',
                $path,
                $yaml
            )
        );
    }
}
