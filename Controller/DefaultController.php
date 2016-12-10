<?php

namespace Fgms\EmailInquiriesBundle\Controller;

class DefaultController extends BaseController
{
    public function homeAction()
    {
        throw new \LogicException('Not implemented');
    }

    public function csvAction(\Symfony\Component\HttpFoundation\Request $request, $key)
    {
        $store = $this->getStoreFromRequest($request);
        $form = $this->getForm($key);
        if ($store !== $form->getForm()->getStore()) throw $this->createNotFoundException(
            sprintf(
                'Form entity with key "%s" is not associated with Store entity with name "%s"',
                $key,
                $store->getName()
            )
        );
        $repo = $this->getSubmissionRepository();
        $submissions = $repo->getOrderedByDate($form->getForm());  //  TODO: Choose order?
        $temp = new \SplTempFileObject();
        $csv = \League\Csv\Writer::createFromFileObject($temp);
        //  For Excel
        $csv->setOutputBOM(\League\Csv\Writer::BOM_UTF8);
        $headings = $form->getHeadings();
        $csv->insertOne($headings);
        foreach ($submissions as $submission) {
            $row = $form->getRow($submission);
            $csv->insertOne($row);
        }
        //  It would be nice if it were possible to use BinaryFileResponse
        //  and stream directly from the temporary file but this is not
        //  currently possible:
        //
        //  https://github.com/symfony/symfony/issues/14969
        //  https://github.com/symfony/symfony/pull/15133
        //$response = new \Symfony\Component\HttpFoundation\BinaryFileResponse($temp);
        $response = new \Symfony\Component\HttpFoundation\Response($csv);
        $response->headers->set('Content-Type','application/force-download');
        $response->headers->set('Content-Type','text/csv; charset=utf-8');
        $response->headers->set(
            'Content-Disposition',
            $response->headers->makeDisposition(
                \Symfony\Component\HttpFoundation\ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                sprintf('%s-export.csv',$key)
            )
        );
        return $response;
    }
}
