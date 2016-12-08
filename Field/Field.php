<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * A convenience base class for domain objects which
 * represent a Field entity.
 */
abstract class Field implements FieldInterface
{
    private $field;

    /**
     * Creates a new Field object.
     *
     * @param Field $field
     */
    public function __construct(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        $this->field = $field;
    }

    public function getField()
    {
        return $this->field;
    }

    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
    }

    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        return [];
    }

    public function filterMessage(\Swift_Message $message, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
    }
}
