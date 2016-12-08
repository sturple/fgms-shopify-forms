<?php

namespace Fgms\EmailInquiriesBundle\Form;

/**
 * Encapsulates the logic of a form.
 */
class Form implements FormInterface
{
    private $swift;
    private $twig;
    private $form;
    private $fields;

    /**
     * Creates a new Form object.
     *
     * @param Form $form
     *  The Form entity whose logic the newly created
     *  Form object shall encapsulate.
     * @param FieldFactoryInterface $factory
     *  A factory object which shall be used to create
     *  Field objects from Field entities.
     * @param Swift_Mailer $swift
     *  The mailer which shall be used to send emails.
     */
    public function __construct(\Fgms\EmailInquiriesBundle\Entity\Form $form, \Fgms\EmailInquiriesBundle\Field\FieldFactoryInterface $factory, \Swift_Mailer $swift, \Twig_Environment $twig)
    {
        $this->form = $form;
        $this->swift = $swift;
        $this->twig = $twig;
        $this->fields = [];
        foreach ($this->form->getFields() as $field) {
            $this->fields[] = $factory->create($field);
        }
        usort($this->fields,function (\Fgms\EmailInquiriesBundle\Field\FieldInterface $a, \Fgms\EmailInquiriesBundle\Field\FieldInterface $b) {
            return $a->getField()->getRenderOrder() - $b->getField()->getRenderOrder();
        });
    }

    public function getForm()
    {
        return $this->form;
    }

    private function toEmail($mixed)
    {
        if (is_string($mixed)) return [$mixed => null];
        return [$mixed->getString('address') => $mixed->getOptionalString('name')];
    }

    private function getEmails($key, $opt = false)
    {
        $params = $this->form->getParams();
        $value = $opt ? $params->getOptionalObjectOrStringOrArray($key) : $params->getObjectOrStringOrArray($key);
        if (is_null($value)) return [];
        if (is_string($value) || ($value instanceof \Fgms\EmailInquiriesBundle\Utility\ObjectWrapper)) return $this->toEmail($value);
        $c = count($value);
        if (!$opt && ($c === 0)) throw new \LogicException('No emails');
        $retr = [];
        for ($i = 0; $i < $c; ++$i) {
            $retr = array_merge($retr,$this->toEmail($value->getObjectOrString($i)));
        }
        return $retr;
    }

    private function toArray(array $emails)
    {
        $retr = [];
        foreach ($emails as $address => $name) {
            $obj = (object)['address' => $address];
            if (!is_null($name)) $obj->name = $name;
            $retr[] = $obj;
        }
        return $retr;
    }

    private function toSubmission(\Swift_Message $msg, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $submission->setTo($this->toArray($msg->getTo()))
            ->setSubject($msg->getSubject())
            ->setBody((string)$msg->getBody())
            ->setForm($this->form)
            ->setFrom($this->toArray($msg->getFrom()))
            ->setCc($this->toArray($msg->getCc()))
            ->setBcc($this->toArray($msg->getBcc()));
    }

    private function getContentType($template)
    {
        $ct = $this->form->getParams()->getOptionalString('content_type');
        if (!is_null($ct)) return $ct;
        if (preg_match('/\\.html\\.twig$/u',$template)) return 'text/html';
        return 'text/plain';
    }

    private function getCharset()
    {
        $cs = $this->form->getParams()->getOptionalString('charset');
        if (!is_null($cs)) return $cs;
        return 'UTF-8';
    }

    private function getTemplate()
    {
        $retr = $this->form->getParams()->getOptionalString('template');
        if (!is_null($retr)) return $retr;
        return 'FgmsEmailInquiriesBundle:Email:default.html.twig';
    }

    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $obj = new ValueWrapper($obj);
        foreach ($this->fields as $field) $field->submit($obj,$submission);
        $msg = new \Swift_Message();
        $params = $this->form->getParams();
        $msg->setFrom($this->getEmails('from'))
            ->setTo($this->getEmails('to',true))
            ->setCc($this->getEmails('cc',true))
            ->setBcc($this->getEmails('bcc',true))
            ->setSubject((string)$params->getOptionalString('subject'))
            ->setCharset($this->getCharset());
        $sections = [];
        foreach ($this->fields as $field) {
            $sections = array_merge($sections,$field->render($submission));
        }
        $ctx = [
            'form' => $this->form,
            'submission' => $submission,
            'sections' => $sections
        ];
        $template = $this->getTemplate();
        $body = $this->twig->render($template,$ctx);
        $msg->setBody($body)
            ->setContentType($this->getContentType($template));
        foreach ($this->fields as $field) {
            $field->filterMessage($msg,$submission);
        }
        $this->swift->send($msg);
        $this->toSubmission($msg,$submission);
    }
}
