<?php

namespace Fgms\EmailInquiriesBundle\Controller;

class SubmitController extends BaseController
{
    private function isContentType(\Symfony\Component\HttpFoundation\Request $request, $type)
    {
        $content_type = $request->headers->get('Content-Type');
        $regex = sprintf(
            '/^\\s*%s\\s*(?:;|$)/u',
            preg_quote($type,'/')
        );
        return !is_null($content_type) && preg_match($regex,$content_type);        
    }

    private function isJson(\Symfony\Component\HttpFoundation\Request $request)
    {
        return $this->isContentType($request,'application/json');
    }

    private function isFormUrlEncoded(\Symfony\Component\HttpFoundation\Request $request)
    {
        return $this->isContentType($request,'application/x-www-form-urlencoded');
    }

    private function normalize(\Symfony\Component\HttpFoundation\Request $request)
    {
        //  Verify that method is POST
        $expected_method = \Symfony\Component\HttpFoundation\Request::METHOD_POST;
        $method = $request->getMethod();
        if ($expected_method !== $method) {
            throw $this->createBadRequestException(
                sprintf(
                    'Expected method "%s" got "%s"',
                    $expected_method,
                    $method
                )
            );
        }
        $body = $request->getContent();
        //  Parse body according to content-type
        if ($this->isJson($request)) {
            try {
                return \Fgms\Json\Json::decodeObject($body);
            } catch (\Fgms\Json\Exception\Exception $ex) {
                throw $this->createBadRequestException(
                    sprintf(
                        'Failed to parse JSON request: %s',
                        $ex->getMessage()
                    ),
                    $ex
                );
            }
        }
        if ($this->isFormUrlEncoded($request)) {
            try {
                return \Fgms\FormUrlEncoded\FormUrlEncoded::decode($body);
            } catch (\Fgms\FormUrlEncoded\Exception\Exception $ex) {
                throw $this->createBadRequestException(
                    sprintf(
                        'Failed to parse form URL encoded request: %s',
                        $ex->getMessage()
                    ),
                    $ex
                );
            }
        }
        throw $this->createBadRequestException(
            sprintf(
                'Unrecognized Content-Type "%s"',
                $request->headers->get('Content-Type')
            )
        );
    }

    private function getTemplate(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $form = $submission->getForm();
        $params = $form->getParams();
        return $params->getOptionalString('template');
    }

    private function getRedirectUrl(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $form = $submission->getForm();
        $params = $form->getParams();
        return $params->getOptionalString('redirect');
    }

    private function getJsonResponse(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $obj = new \stdClass();
        $obj->redirect = $this->getRedirectUrl($submission);
        return new \Symfony\Component\HttpFoundation\JsonResponse($obj);
    }

    private function getHtmlResponse(\Fgms\EmailInquiriesBundle\Entity\Submission $submission)
    {
        $redirect = $this->getRedirectUrl($submission);
        if (!is_null($redirect)) return $this->redirect($redirect);
        $template = $this->getTemplate($submission);
        if (is_null($template)) $template = 'FgmsEmailInquiriesBundle:Submit:submit.html.twig';
        $ctx = ['submission' => $submission];
        return $this->render($template,$ctx);
    }

    public function submitAction(\Symfony\Component\HttpFoundation\Request $request, $key)
    {
        $normalized = $this->normalize($request);
        $form = $this->getForm($key);
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $submission->setIp($request->getClientIp())
            ->setCreated(new \DateTime())
            ->setReferer($request->headers->get('referer'));
        //  Submit data and save Submission entity
        try {
            $form->submit($normalized,$submission);
        } catch (\Fgms\EmailInquiriesBundle\Form\Exception\MissingException $ex) {
            throw $this->createBadRequestException(
                'Missing request data',
                $ex
            );
        } catch (\Fgms\EmailInquiriesBundle\Form\Exception\TypeMismatchException $ex) {
            throw $this->createBadRequestException(
                'Request data has unexpected type',
                $ex
            );
        } catch (\Fgms\EmailInquiriesBundle\Field\Exception\DataException $ex) {
            throw $this->createBadRequestException(
                'Request data violated field requirement',
                $ex
            );
        }
        $em = $this->getEntityManager();
        $em->persist($submission);
        $em->flush();
        //  Send email (if applicable) and re-save Submission entity
        //  (in case an Email entity was attached)
        $msg = $form->getEmail($submission);
        if (!is_null($msg)) {
            $swift = $this->getSwift();
            $swift->send($msg);
        }
        $em->persist($submission);
        $em->flush();
        //  Send response
        if ($this->isJson($request)) return $this->getJsonResponse($submission);
        return $this->getHtmlResponse($submission);
    }
}
