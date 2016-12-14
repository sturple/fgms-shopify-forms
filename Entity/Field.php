<?php

namespace Fgms\EmailInquiriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Fgms\EmailInquiriesBundle\Repository\FieldRepository")
 * @ORM\Table(name="field")
 */
class Field
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Form",inversedBy="fields")
     */
    private $form;

    /**
     * @ORM\OneToMany(targetEntity="FieldSubmission",mappedBy="field")
     */
    private $fieldSubmissions;

    /**
     * @ORM\Column(type="string",length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $params = '{}';

    /**
     * @ORM\Column(type="integer")
     */
    private $renderOrder;

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
     * Set form
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Form $form
     *
     * @return Field
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
     * @return Field
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
     * Set type
     *
     * @param string $type
     *
     * @return Field
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set params
     *
     * @param object $params
     *
     * @return Field
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
     * Set renderOrder
     *
     * @param integer $renderOrder
     *
     * @return Field
     */
    public function setRenderOrder($renderOrder)
    {
        $this->renderOrder = $renderOrder;

        return $this;
    }

    /**
     * Get renderOrder
     *
     * @return integer
     */
    public function getRenderOrder()
    {
        return $this->renderOrder;
    }
}
