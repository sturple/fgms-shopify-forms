<?php

namespace Fgms\EmailInquiriesBundle\Field;

class FieldFactory implements FieldFactoryInterface
{
    public function create(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        throw new Exception\UnrecognizedTypeException($field);
    }
}
