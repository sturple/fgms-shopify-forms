<?php

namespace Fgms\EmailInquiriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Fgms\EmailInquiriesBundle\Repository\FieldSubmissionRepository")
 * @ORM\Table(name="field_submission")
 */
class FieldSubmission
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Submission",inversedBy="fieldSubmissions")
     */
    private $submission;

    /**
     * @ORM\ManyToOne(targetEntity="Field",inversedBy="fieldSubmissions")
     */
    private $field;

    /**
     * @ORM\Column(type="text")
     */
    private $value = '{}';

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
     * @return FieldSubmission
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

    /**
     * Set field
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Field $field
     *
     * @return FieldSubmission
     */
    public function setField(\Fgms\EmailInquiriesBundle\Entity\Field $field = null)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \Fgms\EmailInquiriesBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set value
     *
     * @param object $value
     *
     * @return FieldSubmission
     */
    public function setValue($value)
    {
        $this->value = \Fgms\Json\Json::encode($value);

        return $this;
    }

    /**
     * Get value
     *
     * @return ObjectWrapper
     */
    public function getValue()
    {
        return \Fgms\Json\Json::decodeObject($this->value);
    }
}
