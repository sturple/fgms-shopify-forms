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
     * Retrieves the heading row of the report for this
     * form.
     *
     * @return array
     *  An array of strings each of which is a heading.
     */
    public function getHeadings();

    /**
     * Gets the rows of the report for this form.
     *
     * @param Traversable|array $traversable
     *  A traversable value which yields Submission
     *  entities in the order they should be reported
     *  on.
     *
     * @return Traversable|array
     *  A traversable value which yields arrays of strings
     *  each of which represents a row of the report.
     */
    public function getRows($traversable);
}
