<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * Encapsulates the logic of a field which captures
 * an inquiry from the user.
 */
class InquiryField extends TemplateField
{
    use HasStringValue;

    public function submit(\Fgms\ValueWrapper\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getValue($obj);
        $this->getFieldSubmission($submission)
            ->setValue((object)['inquiry' => $value]);
    }

    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getFieldSubmission($submission)->getValue()->getString('inquiry');
        return $this->renderTemplate($submission,['inquiry' => $value]);
    }
}
