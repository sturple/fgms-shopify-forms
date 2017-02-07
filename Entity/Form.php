<?php

namespace Fgms\EmailInquiriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Fgms\EmailInquiriesBundle\Repository\FormRepository")
 * @ORM\Table(name="shopify_forms_form",uniqueConstraints={@ORM\UniqueConstraint(name="key_idx",columns={"key"})})
 */
class Form
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=32,name="`key`")
     */
    private $key;

    /**
     * @ORM\OneToMany(targetEntity="Submission",mappedBy="form")
     */
    private $submissions;

    /**
     * @ORM\OneToMany(targetEntity="Field",mappedBy="form",cascade={"all"})
     */
    private $fields;

    /**
     * @ORM\Column(type="text")
     */
    private $params = '{}';

    /**
     * @ORM\ManyToOne(targetEntity="Store",inversedBy="forms")
     */
    private $store;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->submissions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set key
     *
     * @param string $key
     *
     * @return Form
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Add submission
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Submission $submission
     *
     * @return Form
     */
    public function addSubmission(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $this->submissions[] = $submission;

        return $this;
    }

    /**
     * Remove submission
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Submission $submission
     */
    public function removeSubmission(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $this->submissions->removeElement($submission);
    }

    /**
     * Get submissions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubmissions()
    {
        return $this->submissions;
    }

    /**
     * Add field
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Field $field
     *
     * @return Form
     */
    public function addField(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Field $field
     */
    public function removeField(\Fgms\EmailInquiriesBundle\Entity\Field $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set params
     *
     * @param object $params
     *
     * @return Form
     */
    public function setParams($params)
    {
        $this->params = \Fgms\Json\Json::encode($params);

        return $this;
    }

    /**
     * Get params
     *
     * @return ObjectWrapper
     */
    public function getParams()
    {
        return \Fgms\Json\Json::decodeObject($this->params);
    }

    /**
     * Set store
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Store $store
     *
     * @return Form
     */
    public function setStore(\Fgms\EmailInquiriesBundle\Entity\Store $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return \Fgms\EmailInquiriesBundle\Entity\Store
     */
    public function getStore()
    {
        return $this->store;
    }
}
