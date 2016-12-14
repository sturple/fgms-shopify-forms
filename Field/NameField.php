<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * Encapsulates the logic of a field which captures
 * the name of the user.
 */
class NameField extends TemplateField
{
    use HasStringValue;

    public function submit(\Fgms\ValueWrapper\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getValue($obj);
        $this->getFieldSubmission($submission)
            ->setValue((object)['name' => $value]);
    }

    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getFieldSubmission($submission)->getValue()->getString('name');
        return $this->renderTemplate($submission,['name' => $value]);
    }
}
