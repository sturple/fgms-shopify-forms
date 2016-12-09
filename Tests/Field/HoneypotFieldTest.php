<?php

namespace Fgms\EmailInquiriesBundle\Tests\Field;

class HoneypotFieldTest extends \PHPUnit_Framework_TestCase
{
    private $field;

    protected function setUp()
    {
        $entity = new \Fgms\EmailInquiriesBundle\Entity\Field();
        $entity->setParams((object)['name' => 'honeypot']);
        $this->field = new \Fgms\EmailInquiriesBundle\Field\HoneypotField($entity);
    }

    public function testSubmit()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $obj = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['honeypot' => '']);
        $this->field->submit($obj,$submission);
        $fss = $submission->getFieldSubmissions();
        $this->assertCount(0,$fss);
        $fss = $this->field->getField()->getFieldSubmissions();
        $this->assertCount(0,$fss);
    }

    public function testSubmitFail()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $obj = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['honeypot' => 'foo']);
        $this->expectException(\Fgms\EmailInquiriesBundle\Field\Exception\HoneypotException::class);
        $this->expectExceptionMessage('Field "honeypot" not empty (has value "foo")');
        $this->field->submit($obj,$submission);
    }
}
