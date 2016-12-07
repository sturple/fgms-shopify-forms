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

    protected function getFieldFactory()
    {
        //  In future parameters may be needed here
        return new \Fgms\EmailInquiriesBundle\Field\FieldFactory();
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
        $factory = $this->getFieldFactory();
        return new \Fgms\EmailInquiriesBundle\Form\Form($form,$factory,$swift);
    }
}
