<?php

namespace Fgms\EmailInquiriesBundle\Field;

class FieldFactory implements FieldFactoryInterface
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function create(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        $type = $field->getType();
        if ($type === 'email') return new EmailField($field);
        if ($type === 'inquiry') return new InquiryField($field,$this->twig);
        if ($type === 'name') return new NameField($field,$this->twig);
        throw new Exception\UnrecognizedTypeException($field);
    }
}
