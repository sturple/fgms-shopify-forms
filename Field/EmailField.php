<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * Collects the email address of the person
 * filling out the form and sets the resulting
 * email to Reply-To them.
 */
class EmailField extends TemplateField
{
    use HasStringValue;

    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $email = $this->getValue($obj);
        $this->getFieldSubmission($submission)
            ->setValue((object)['email' => $email]);
    }

    public function filterMessage(\Swift_Message $message, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $fs = $this->getFieldSubmission($submission);
        $message->setReplyTo([$fs->getValue()->getString('email') => null]);
    }

    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getFieldSubmission($submission)->getValue()->getString('email');
        return $this->renderTemplate($submission,['email' => $value]);
    }
}
