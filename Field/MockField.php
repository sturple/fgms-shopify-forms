<?php

namespace Fgms\EmailInquiriesBundle\Field;

class MockField extends Field
{
    private $render = [];
    private $submission;
    private $wrapper;
    private $message;
    private $headings;
    private $rows = [];

    public function addRow(array $row)
    {
        $this->rows[] = $row;
        return $this;
    }

    public function setHeadings(array $headings)
    {
        $this->headings = $headings;
        return $this;
    }

    public function setRender(array $render)
    {
        $this->render = $render;
        return $this;
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

    public function getHeadings()
    {
        if (is_null($this->headings)) throw new \LogicException('getHeadings invoked again');
        $retr = $this->headings;
        $this->headings = null;
        return $retr;
    }

    public function getColumns(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        if (count($this->rows) === 0) throw new \LogicException('No rows');
        return array_shift($this->rows);
    }
}
