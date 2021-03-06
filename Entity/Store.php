<?php

namespace Fgms\EmailInquiriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Fgms\EmailInquiriesBundle\Repository\StoreRepository")
 * @ORM\Table(name="shopify_forms_store",uniqueConstraints={@ORM\UniqueConstraint(name="name_idx",columns={"name"})})
 */
class Store
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $accessToken;

    /**
     * @ORM\Column(type="string",length=100)
     */
    private $status = 'active';

    /**
     * @ORM\OneToMany(targetEntity="Form",mappedBy="store")
     */
    private $forms;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->forms = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Store
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set accessToken
     *
     * @param string $accessToken
     *
     * @return Store
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Store
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add form
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Form $form
     *
     * @return Store
     */
    public function addForm(\Fgms\EmailInquiriesBundle\Entity\Form $form)
    {
        $this->forms[] = $form;

        return $this;
    }

    /**
     * Remove form
     *
     * @param \Fgms\EmailInquiriesBundle\Entity\Form $form
     */
    public function removeForm(\Fgms\EmailInquiriesBundle\Entity\Form $form)
    {
        $this->forms->removeElement($form);
    }

    /**
     * Get forms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForms()
    {
        return $this->forms;
    }
}
