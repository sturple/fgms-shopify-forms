<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * Encapsulates the logic of a field which attempts
 * to detect bot-submitted forms.
 *
 * The field which objects of this class monitors is
 * expected to be empty.
 */
class HoneypotField extends Field
{
    use HasStringValue;

    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $value = $this->getValue($obj);
        if ($value !== '') throw new Exception\HoneypotException(
            sprintf(
                'Field "%s" not empty (has value "%s")',
                $this->getName(),
                $value
            )
        );
    }
}
