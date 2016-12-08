<?php

namespace Fgms\EmailInquiriesBundle\Field;

class FieldFactory implements FieldFactoryInterface
{
    public function create(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        $type = $field->getType();
        if ($type === 'email') return new EmailField($field);
        throw new Exception\UnrecognizedTypeException($field);
    }
}
