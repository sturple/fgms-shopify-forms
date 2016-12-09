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

    private function getNameFieldSubmission(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        foreach ($submission->getFieldSubmissions() as $fs) {
            if ($fs->getField()->getType() === 'name') return $fs;
        }
        return null;
    }

    public function filterMessage(\Swift_Message $message, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $fs = $this->getFieldSubmission($submission);
        $name_fs = $this->getNameFieldSubmission($submission);
        $name = null;
        if (!is_null($name_fs)) $name = $name_fs->getValue()->getString('name');
        $addr = $fs->getValue()->getString('email');
        $arr = [$addr => $name];
        $from = $message->getFrom();
        $message->setSender($from)
            ->setReplyTo($arr)
            ->setFrom($arr);
    }

    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getFieldSubmission($submission)->getValue()->getString('email');
        return $this->renderTemplate($submission,['email' => $value]);
    }
}
