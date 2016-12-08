<?php

namespace Fgms\EmailInquiriesBundle\Field;

class MockFieldFactory implements FieldFactoryInterface
{
    private $fields = [];

    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;
    }

    public function create(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        if (count($this->fields) === 0) throw new \LogicException('No fields');
        $obj = array_shift($this->fields);
        if ($obj->getField() !== $field) throw new \LogicException('Mismatch');
        return $obj;
    }
}
