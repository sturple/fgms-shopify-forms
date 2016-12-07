<?php

namespace Fgms\EmailInquiriesBundle\Form;

/**
 * Encapsulates the logic of a form.
 */
class Form implements FormInterface
{
    private $swift;
    private $form;
    private $fields;

    public function __construct(\Fgms\EmailInquiriesBundle\Entity\Form $form, \Fgms\EmailInquiriesBundle\Field\FieldFactoryInterface $factory, \Swift_Mailer $swift)
    {
        $this->form = $form;
        $this->swift = $swift;
        $this->fields = [];
        foreach ($this->form->getFields() as $field) {
            $this->fields[] = $factory->create($field);
        }
    }

    public function getForm()
    {
        return $this->form;
    }

    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj)
    {
        var_dump($obj);
        die();
    }
}
