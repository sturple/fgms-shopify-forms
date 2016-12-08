<?php

namespace Fgms\EmailInquiriesBundle\Tests\Field;

class InquiryFieldTest extends \PHPUnit_Framework_TestCase
{
    private $field;
    private $twig;

    protected function setUp()
    {
        $this->twig = new \Twig_Loader_Array([
            'FgmsEmailInquiriesBundle:Field:inquiry.html.twig' => '{{inquiry|raw}}'
        ]);
        $entity = new \Fgms\EmailInquiriesBundle\Entity\Field();
        $entity->setParams((object)['name' => 'inquiry']);
        $twig = new \Twig_Environment($this->twig);
        $this->field = new \Fgms\EmailInquiriesBundle\Field\InquiryField($entity,$twig);
    }

    public function testSubmit()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $obj = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['inquiry' => 'Hello world!']);
        $this->field->submit($obj,$submission);
        $fss = $submission->getFieldSubmissions();
        $this->assertCount(1,$fss);
        $fs = $fss[0];
        $this->assertSame($submission,$fs->getSubmission());
        $this->assertSame($this->field->getField(),$fs->getField());
        $obj = $fs->getValue()->unwrap();
        $vars = get_object_vars($obj);
        $this->assertCount(1,$vars);
        $this->assertArrayHasKey('inquiry',$vars);
        $this->assertSame('Hello world!',$vars['inquiry']);
        $fss = $this->field->getField()->getFieldSubmissions();
        $this->assertCount(1,$fss);
        $this->assertSame($fs,$fss[0]);
    }

    public function testRender()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $fs = new \Fgms\EmailInquiriesBundle\Entity\FieldSubmission();
        $fs->setSubmission($submission)
            ->setField($this->field->getField())
            ->setValue((object)['inquiry' => 'Hello world!']);
        $this->field->getField()->addFieldSubmission($fs);
        $submission->addFieldSubmission($fs);
        $arr = $this->field->render($submission);
        $this->assertCount(1,$arr);
        $this->assertArrayHasKey(0,$arr);
        $this->assertSame('Hello world!',$arr[0]);
    }
}
