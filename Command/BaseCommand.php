<?php

namespace Fgms\EmailInquiriesBundle\Command;

abstract class BaseCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    protected function getEntityManager()
    {
        $doctrine = $this->getDoctrine();
        return $doctrine->getEntityManager();
    }

    protected function getFormRepository()
    {
        $doctrine = $this->getDoctrine();
        return $doctrine->getRepository(\Fgms\EmailInquiriesBundle\Entity\Form::class);
    }
}
