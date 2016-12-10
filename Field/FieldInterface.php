<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * An interface for domain objects which represent
 * a Field entity.
 */
interface FieldInterface
{
    /**
     * Retrieves the wrapped Field entity.
     *
     * @return Field
     */
    public function getField();

    /**
     * Processes the submission of this field.
     *
     * @param ValueWrapper $obj
     *  All values submitted as part of the current request.
     * @param Submission $submission
     *  The Submission entity associated with this submission.
     */
    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission);

    /**
     * Generates sections for the email from submitted
     * data for this field.
     *
     * @param Submission $submission
     *  The Submission entity associated with this submission.
     *
     * @return array
     *  An array of strings each of which is the raw body
     *  of a section.
     */
    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission);

    /**
     * Allows a field an opportunity to adjust the message
     * before it is sent.
     *
     * @param Swift_Message $message
     *  An object representing the email message which is about
     *  to be sent.
     * @param Submission $submission
     *  The Submission entity associated with this submission.
     */
    public function filterMessage(\Swift_Message $message, \Fgms\EmailInquiriesBundle\Entity\Submission $submission);

    /**
     * Gets the headings of the columns this field generates
     * in reports.
     *
     * @return array
     *  An array of strings representing the headings.
     */
    public function getHeadings();

    /**
     * Gets the values of the columns this field generates
     * in reports for a certain submission.
     *
     * @param Submission $submission
     *  Must not be mutated.
     *
     * @return array
     *  An array of strings representing the headings.
     */
    public function getColumns(\Fgms\EmailInquiriesBundle\Entity\Submission $submission);
}
