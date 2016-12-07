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
     *
     * @return Submission
     *  A Submission entity representing the submission
     *  of the request.
     */
    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj);
}
