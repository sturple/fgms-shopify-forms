<?php

namespace Fgms\EmailInquiriesBundle\Field\Exception;

/**
 * Thrown when a FieldFactoryInterface instance encounters
 * a Field entity with a type for which it is unable to
 * construct a domain object.
 */
class UnrecognizedTypeException extends Exception
{
    private $entity;

    /**
     * Creates a new UnrecognizedTypeException.
     *
     * @param Field $field
     *  The Field entity with the unrecognized type.
     */
    public function __construct(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        parent::__construct(
            sprintf(
                'Unrecognized field type "%s"',
                $field->getType()
            )
        );
        $this->entity = $field;
    }

    /**
     * Retrieves the Field entity which caused this
     * exception to be thrown.
     *
     * @return Field
     */
    public function getField()
    {
        return $this->entity;
    }
}
