<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * A convenience base class for field objects which
 * render templates.
 */
abstract class TemplateField extends Field
{
    private $twig;

    public function __construct(\Fgms\EmailInquiriesBundle\Entity\Field $field, \Twig_Environment $twig)
    {
        parent::__construct($field);
        $this->twig = $twig;
    }

    private function getTemplate()
    {
        $template = $this->getField()->getParams()->getOptionalString('template');
        if (!is_null($template)) return $template;
        $name = get_class($this);
        $name = preg_replace('/^(?:.*\\\\)?([^\\\\]+)$/u','$1',$name);
        $name = preg_replace('/Field$/u','',$name);
        $name = strtolower($name);
        return sprintf('FgmsEmailInquiriesBundle:Field:%s.html.twig',$name);
    }

    /**
     * Renders a template with a certain context.
     *
     * @param Submission $submission
     * @param array $ctx
     *  Values to merge with the automatically generated
     *  template context.  Defaults to an empty array.
     *
     * @return array
     *  An array with a single string which is the result
     *  of rendering the template associated with this
     *  object.
     */
    protected function renderTemplate(\Fgms\EmailInquiriesBundle\Entity\Submission $submission, array $ctx = [])
    {
        $ctx = array_merge([
            'field' => $this->getField(),
            'submission' => $submission
        ],$ctx);
        $template = $this->getTemplate();
        $str = $this->twig->render($template,$ctx);
        return [$str];
    }
}
