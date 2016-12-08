<?php

namespace Fgms\EmailInquiriesBundle\Tests\Field;

class EmailFieldTest extends \PHPUnit_Framework_TestCase
{
    private $field;

    protected function setUp()
    {
        $entity = new \Fgms\EmailInquiriesBundle\Entity\Field();
        $entity->setParams((object)['name' => 'email']);
        $this->field = new \Fgms\EmailInquiriesBundle\Field\EmailField($entity);
    }

    public function testSubmit()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $obj = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['email' => 'rleahy@fifthgeardev.com']);
        $this->field->submit($obj,$submission);
        $fss = $submission->getFieldSubmissions();
        $this->assertCount(1,$fss);
        $fs = $fss[0];
        $this->assertSame($submission,$fs->getSubmission());
        $this->assertSame($this->field->getField(),$fs->getField());
        $obj = $fs->getValue()->unwrap();
        $vars = get_object_vars($obj);
        $this->assertCount(1,$vars);
        $this->assertArrayHasKey('email',$vars);
        $this->assertSame('rleahy@fifthgeardev.com',$vars['email']);
        $fss = $this->field->getField()->getFieldSubmissions();
        $this->assertCount(1,$fss);
        $this->assertSame($fs,$fss[0]);
    }

    public function testFilterMessage()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $fs = new \Fgms\EmailInquiriesBundle\Entity\FieldSubmission();
        $fs->setSubmission($submission)
            ->setField($this->field->getField())
            ->setValue((object)['email' => 'foo@example.org']);
        $this->field->getField()->addFieldSubmission($fs);
        $submission->addFieldSubmission($fs);
        $msg = new \Swift_Message();
        $this->field->filterMessage($msg,$submission);
        $rt = $msg->getReplyTo();
        $this->assertCount(1,$rt);
        $this->assertArrayHasKey('foo@example.org',$rt);
        $this->assertNull($rt['foo@example.org']);
    }
}
