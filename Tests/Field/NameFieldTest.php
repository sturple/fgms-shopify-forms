<?php

namespace Fgms\EmailInquiriesBundle\Tests\Field;

class NameFieldTest extends \PHPUnit_Framework_TestCase
{
    private $field;
    private $twig;

    protected function setUp()
    {
        $this->twig = new \Twig_Loader_Array([
            'FgmsEmailInquiriesBundle:Field:name.html.twig' => '{{name|raw}}'
        ]);
        $entity = new \Fgms\EmailInquiriesBundle\Entity\Field();
        $entity->setParams((object)['name' => 'name']);
        $twig = new \Twig_Environment($this->twig);
        $this->field = new \Fgms\EmailInquiriesBundle\Field\NameField($entity,$twig);
    }

    public function testSubmit()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $obj = new \Fgms\ValueWrapper\ValueWrapperImpl((object)['name' => 'Robert Leahy']);
        $this->field->submit($obj,$submission);
        $fss = $submission->getFieldSubmissions();
        $this->assertCount(1,$fss);
        $fs = $fss[0];
        $this->assertSame($submission,$fs->getSubmission());
        $this->assertSame($this->field->getField(),$fs->getField());
        $obj = $fs->getValue()->unwrap();
        $vars = get_object_vars($obj);
        $this->assertCount(1,$vars);
        $this->assertArrayHasKey('name',$vars);
        $this->assertSame('Robert Leahy',$vars['name']);
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
            ->setValue((object)['name' => 'Robert Leahy']);
        $this->field->getField()->addFieldSubmission($fs);
        $submission->addFieldSubmission($fs);
        $arr = $this->field->render($submission);
        $this->assertCount(1,$arr);
        $this->assertArrayHasKey(0,$arr);
        $this->assertSame('Robert Leahy',$arr[0]);
    }
}
