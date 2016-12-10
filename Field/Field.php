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

    public function getHeadings()
    {
        return [];
    }

    public function getColumns(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        return [];
    }

    /**
     * Obtains a FieldSubmission entity for the wrapped
     * Form entity and the provided Submission entity.
     *
     * The resulting entity will have the appropriate
     * Field entity and Submission entity populated,
     * and the resulting entity will be added to the
     * FieldSubmission collections of the appropriate
     * Field entity and Submission entity.
     *
     * Note that this method creates a new FieldSubmission
     * entity only if the provided Submission entity
     * does not already have a suitable FieldSubmission
     * entity.
     *
     * @param Submission $submission
     *
     * @return FieldSubmission
     */
    protected function getFieldSubmission(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        foreach ($submission->getFieldSubmissions() as $fs) {
            if ($fs->getField() === $this->field) return $fs;
        }
        $retr = new \Fgms\EmailInquiriesBundle\Entity\FieldSubmission();
        $retr->setField($this->field)
            ->setSubmission($submission);
        $submission->addFieldSubmission($retr);
        $this->field->addFieldSubmission($retr);
        return $retr;
    }
}
