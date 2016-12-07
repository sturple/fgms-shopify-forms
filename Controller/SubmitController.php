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
                return \Fgms\EmailInquiriesBundle\Json\Json::decodeObject($body);
            } catch (\Fgms\EmailInquiriesBundle\Json\Exception\Exception $ex) {
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
                return \Fgms\EmailInquiriesBundle\FormUrlEncoded\FormUrlEncoded::decode($body);
            } catch (\Fgms\EmailInquiriesBundle\FormUrlEncoded\Exception\Exception $ex) {
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

    public function submitAction(\Symfony\Component\HttpFoundation\Request $request, $key)
    {
        $normalized = $this->normalize($request);
        $form = $this->getForm($key);
        $submission = $form->submit($normalized);
        die();
    }
}
