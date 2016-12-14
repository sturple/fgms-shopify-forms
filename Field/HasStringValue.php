<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * A mixin for fields which extract a single field
 * from the request which they expect to be a string.
 */
trait HasStringValue
{
    private function getName()
    {
        return $this->getField()->getParams()->getString('name');
    }

    private function getValue(\Fgms\ValueWrapper\ValueWrapper $obj)
    {
        return $obj->getString($this->getName());
    }
}
