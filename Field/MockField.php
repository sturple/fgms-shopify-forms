<?php

namespace Fgms\EmailInquiriesBundle\Field;

class MockField extends Field
{
    private $render = [];
    private $submission;
    private $wrapper;
    private $message;

    public function setRender(array $render)
    {
        $this->render = $render;
    }

    public function submit(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        if (!is_null($this->wrapper)) throw new \LogicException('submit invoked again');
        $this->submission = $submission;
        $this->wrapper = $obj;
    }

    public function render(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        if (is_null($this->render)) throw new \LogicException('render invoked again');
        $this->submission = $submission;
        $retr = $this->render;
        $this->render = null;
        return $retr;
    }

    public function filterMessage(\Swift_Message $message, \Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        if (!is_null($this->message)) throw new \LogicException('filterMessage invoked again');
        $this->submission = $submission;
        $this->message = $message;
    }

    public function getRequest()
    {
        if (is_null($this->wrapper)) throw new \LogicException('submit not invoked');
        return $this->wrapper;
    }

    public function isRendered()
    {
        return is_null($this->render);
    }

    public function getSubmission()
    {
        if (is_null($this->submission)) throw new \LogicException('No Submission entity');
        return $this->submission;
    }

    public function getMessage()
    {
        if (is_null($this->message)) throw new \LogicException('filterMessage not invoked');
        return $this->message;
    }
}
