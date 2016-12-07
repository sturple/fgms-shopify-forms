<?php

namespace Fgms\EmailInquiriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Fgms\EmailInquiriesBundle\Repository\SubmissionRepository")
 * @ORM\Table(name="submission")
 */
class Submission
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=45)
     */
    private $ip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $referer;

    /**
     * @ORM\Column(type="text",name="`from`")
     */
    private $from = '[]';

    /**
     * @ORM\Column(type="text")
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
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Form",inversedBy="submissions")
     */
    private $form;

    /**
     * @ORM\OneToMany(targetEntity="FieldSubmission",mappedBy="submission")
     */
    private $fieldSubmissions;

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
     * Set ip
     *
     * @param string $ip
     *
     * @return Submission
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Submission
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = \Fgms\EmailInquiriesBundle\Utility\DateTime::toDoctrine($created);

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created = \Fgms\EmailInquiriesBundle\Utility\DateTime::fromDoctrine($this->created);
    }

    /**
     * Set referer
     *
     * @param string $referer
     *
     * @return Submission
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

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
     * Set form
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Form $form
     *
     * @return Submission
     */
    public function setForm(\Fgms\EmailInquiriesBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \Fgms\EmailInquiriesBundle\Entity\Form
     */
    public function getForm()
    {
        return $this->form;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fieldSubmissions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add fieldSubmission
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\FieldSubmission $fieldSubmission
     *
     * @return Submission
     */
    public function addFieldSubmission(\Fgms\EmailInquiriesBundle\Entity\FieldSubmission $fieldSubmission)
    {
        $this->fieldSubmissions[] = $fieldSubmission;

        return $this;
    }

    /**
     * Remove fieldSubmission
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\FieldSubmission $fieldSubmission
     */
    public function removeFieldSubmission(\Fgms\EmailInquiriesBundle\Entity\FieldSubmission $fieldSubmission)
    {
        $this->fieldSubmissions->removeElement($fieldSubmission);
    }

    /**
     * Get fieldSubmissions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFieldSubmissions()
    {
        return $this->fieldSubmissions;
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
}
