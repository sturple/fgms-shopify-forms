<?php

namespace Fgms\EmailInquiriesBundle\Form;

/**
 * An interface for domain objects which represent
 * a Form entity.
 */
interface FormInterface
{
    /**
     * Retrieves the wrapped Form entity.
     *
     * @return Form
     */
    public function getForm();

    /**
     * Processes a submission against the form.
     *
     * @param ValueWrapper $obj
     *  An object representing the values of the HTTP request
     *  which was submitted.
     * @param Submission $submission
     *  A Submission entity representing the submission.
     */
    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission);

    /**
     * Creates a Swift_Message for a submission if applicable.
     *
     * @param Submission $submission
     *  A Submission entity representing the submission.  An
     *  Email entity should be attached to this entity by this
     *  method if a Swift_Message is returned.
     *
     * @return Swift_Message|null
     */
    public function getEmail(\Fgms\EmailInquiriesBundle\Entity\Submission $submission);

    /**
     * Retrieves the heading row of the report for this
     * form.
     *
     * @return array
     *  An array of strings each of which is a heading.
     */
    public function getHeadings();

    /**
     * Gets a row of the report for this form.
     *
     * @param Submission $submission
     *  The Submission entity to generate the row for.
     *
     * @return array
     *  An array of strings each of which is a column.
     */
    public function getRow(\Fgms\EmailInquiriesBundle\Entity\Submission $submission);
}
