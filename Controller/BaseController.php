<?php

namespace Fgms\EmailInquiriesBundle\Controller;

abstract class BaseController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    protected function getFormRepository()
    {
        $doctrine = $this->getDoctrine();
        return $doctrine->getRepository(\Fgms\EmailInquiriesBundle\Entity\Form::class);
    }

    protected function createBadRequestException($message = 'Bad Request', $previous = null)
    {
        return new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException($message,$previous);
    }

    protected function getTwigEnvironment()
    {
        return $this->container->get('twig');
    }

    protected function getFieldFactory()
    {
        $twig = $this->getTwigEnvironment();
        return new \Fgms\EmailInquiriesBundle\Field\FieldFactory($twig);
    }

    protected function getForm($key)
    {
        //  Find Form entity
        $repo = $this->getFormRepository();
        $form = $repo->findOneByKey($key);
        if (is_null($form)) throw $this->createNotFoundException(
            sprintf(
                'No Form with key "%s"',
                $key
            )
        );
        //  Gather dependencies and create Form domain
        //  object
        $swift = $this->container->get('swiftmailer.mailer');
        $twig = $this->getTwigEnvironment();
        $factory = $this->getFieldFactory();
        return new \Fgms\EmailInquiriesBundle\Form\Form($form,$factory,$swift,$twig);
    }

    protected function getEntityManager()
    {
        $doctrine = $this->getDoctrine();
        return $doctrine->getEntityManager();
    }
}
