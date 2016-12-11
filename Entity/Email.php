<?php

namespace Fgms\EmailInquiriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Fgms\EmailInquiriesBundle\Repository\EmailRepository")
 * @ORM\Table(name="email")
 */
class Email
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text",name="`from`")
     */
    private $from = '[]';

    /**
     * @ORM\Column(type="text")
     */
    private $sender = '[]';

    /**
     * @ORM\Column(type="text")
     */
    private $replyTo = '[]';

    /**
     * @ORM\Column(type="text",name="`to`")
     */
    private $to = '[]';

    /**
     * @ORM\Column(type="text")
     */
    private $cc = '[]';

    /**
     * @ORM\Column(type="text")
     */
    private $bcc = '[]';

    /**
     * @ORM\Column(type="text")
     */
    private $headers;

    /**
     * @ORM\Column(type="text")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\OneToOne(targetEntity="Submission",inversedBy="email")
     */
    private $submission;

    /**
     * Set to
     *
     * @param array $to
     *
     * @return Submission
     */
    public function setTo(array $to)
    {
        $this->to = \Fgms\EmailInquiriesBundle\Json\Json::encode($to);

        return $this;
    }

    /**
     * Get to
     *
     * @return ArrayWrapper
     */
    public function getTo()
    {
        return \Fgms\EmailInquiriesBundle\Json\Json::decodeArray($this->to);
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Submission
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Submission
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set from
     *
     * @param array $from
     *
     * @return Submission
     */
    public function setFrom(array $from)
    {
        $this->from = \Fgms\EmailInquiriesBundle\Json\Json::encode($from);

        return $this;
    }

    /**
     * Get from
     *
     * @return ArrayWrapper
     */
    public function getFrom()
    {
        return \Fgms\EmailInquiriesBundle\Json\Json::decodeArray($this->from);
    }

    /**
     * Set cc
     *
     * @param array $cc
     *
     * @return Submission
     */
    public function setCc(array $cc)
    {
        $this->cc = \Fgms\EmailInquiriesBundle\Json\Json::encode($cc);

        return $this;
    }

    /**
     * Get cc
     *
     * @return ArrayWrapper
     */
    public function getCc()
    {
        return \Fgms\EmailInquiriesBundle\Json\Json::decodeArray($this->cc);
    }

    /**
     * Set bcc
     *
     * @param array $bcc
     *
     * @return Submission
     */
    public function setBcc(array $bcc)
    {
        $this->bcc = \Fgms\EmailInquiriesBundle\Json\Json::encode($bcc);

        return $this;
    }

    /**
     * Get bcc
     *
     * @return ArrayWrapper
     */
    public function getBcc()
    {
        return \Fgms\EmailInquiriesBundle\Json\Json::decodeArray($this->bcc);
    }

    /**
     * Set sender
     *
     * @param array $sender
     *
     * @return Submission
     */
    public function setSender(array $sender)
    {
        $this->sender = \Fgms\EmailInquiriesBundle\Json\Json::encode($sender);

        return $this;
    }

    /**
     * Get sender
     *
     * @return ArrayWrapper
     */
    public function getSender()
    {
        return \Fgms\EmailInquiriesBundle\Json\Json::decodeArray($this->sender);
    }

    /**
     * Set replyTo
     *
     * @param array $replyTo
     *
     * @return Submission
     */
    public function setReplyTo(array $replyTo)
    {
        $this->replyTo = \Fgms\EmailInquiriesBundle\Json\Json::encode($replyTo);

        return $this;
    }

    /**
     * Get replyTo
     *
     * @return ArrayWrapper
     */
    public function getReplyTo()
    {
        return \Fgms\EmailInquiriesBundle\Json\Json::decodeArray($this->replyTo);
    }

    /**
     * Set headers
     *
     * @param string $headers
     *
     * @return Submission
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get headers
     *
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set submission
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Submission $submission
     *
     * @return Email
     */
    public function setSubmission(\Fgms\EmailInquiriesBundle\Entity\Submission $submission = null)
    {
        $this->submission = $submission;

        return $this;
    }

    /**
     * Get submission
     *
     * @return \Fgms\EmailInquiriesBundle\Entity\Submission
     */
    public function getSubmission()
    {
        return $this->submission;
    }
}
