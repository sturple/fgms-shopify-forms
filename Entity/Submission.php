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
     * @ORM\ManyToOne(targetEntity="Form",inversedBy="submissions")
     */
    private $form;

    /**
     * @ORM\OneToMany(targetEntity="FieldSubmission",mappedBy="submission",cascade={"all"})
     */
    private $fieldSubmissions;

    /**
     * @ORM\OneToOne(targetEntity="Email",mappedBy="submission",cascade={"all"})
     */
    private $email;

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
     * Set email
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Email $email
     *
     * @return Submission
     */
    public function setEmail(\Fgms\EmailInquiriesBundle\Entity\Email $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \Fgms\EmailInquiriesBundle\Entity\Email
     */
    public function getEmail()
    {
        return $this->email;
    }
}
