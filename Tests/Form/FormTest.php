<?php

namespace Fgms\EmailInquiriesBundle\Tests\Form;

class FormTest extends \PHPUnit_Framework_TestCase
{
    private $swift;
    private $form;
    private $factory;

    protected function setUp()
    {
        $this->form = new \Fgms\EmailInquiriesBundle\Entity\Form();
        $this->swift = new \Fgms\EmailInquiriesBundle\Swift\MockTransport();
        $this->factory = new \Fgms\EmailInquiriesBundle\Field\MockFieldFactory();
    }

    private function createField($id, $type, $order, array $params = [])
    {
        $retr = new \Fgms\EmailInquiriesBundle\Entity\Field();
        $retr->setForm($this->form)
            ->setType($type)
            ->setRenderOrder($order)
            ->setParams((object)$params);
        $rc = new \ReflectionClass($retr);
        $prop = $rc->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($retr,$id);
        return $retr;
    }

    private function create(array $params = [])
    {
        $params = array_merge([
            'from' => 'rleahy@fifthgeardev.com',
            'to' => (object)[
                'name' => 'Shawn Turple',
                'address' => 'sturple@fifthgeardev.com'
            ],
            'bcc' => [
                (object)[
                    'address' => 'foo@example.org'
                ]
            ]
        ],$params);
        $this->form->setParams((object)$params);
        $swift = \Swift_Mailer::newInstance($this->swift);
        return new \Fgms\EmailInquiriesBundle\Form\Form(
            $this->form,
            $this->factory,
            $swift
        );
    }

    public function testSubmit()
    {
        $field_entity_a = $this->createField(1,'foo',1);
        $field_object_a = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_a);
        $this->factory->addField($field_object_a);
        $this->form->addField($field_entity_a);
        $field_entity_b = $this->createField(2,'bar',0);
        $field_object_b = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_b);
        $this->factory->addField($field_object_b);
        $this->form->addField($field_entity_b);
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $dt = new \DateTime();
        $submission->setIp('127.0.0.1')
            ->setCreated(clone $dt)
            ->setReferer('http://google.ca');
        //  TODO: Setup
        $form = $this->create();
        $request = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)[
            //  TODO: Actually have request data
        ]);
        $form->submit($request,$submission);
        //  Verify sent emails
        $msgs = $this->swift->getMessages();
        $this->assertCount(1,$msgs);
        $msg = $msgs[0];
        $from = $msg->getFrom();
        $this->assertCount(1,$from);
        $this->assertArrayHasKey('rleahy@fifthgeardev.com',$from);
        $this->assertNull($from['rleahy@fifthgeardev.com']);
        $to = $msg->getTo();
        $this->assertCount(1,$to);
        $this->assertArrayHasKey('sturple@fifthgeardev.com',$to);
        $this->assertSame('Shawn Turple',$to['sturple@fifthgeardev.com']);
        $cc = $msg->getCc();
        $this->assertCount(0,$cc);
        $bcc = $msg->getBcc();
        $this->assertCount(1,$bcc);
        $this->assertArrayHasKey('foo@example.org',$bcc);
        $this->assertNull($bcc['foo@example.org']);
        //  TODO: Verify body
        //  Verify Submission entity
        $this->assertSame('127.0.0.1',$submission->getIp());
        $this->assertSame($dt->getTimestamp(),$submission->getCreated()->getTimestamp());
        $this->assertSame('http://google.ca',$submission->getReferer());
        $from = $submission->getFrom();
        $this->assertCount(1,$from);
        $this->assertSame('rleahy@fifthgeardev.com',$from[0]->address);
        $this->assertFalse(isset($from[0]->name));
        $to = $submission->getTo();
        $this->assertCount(1,$to);
        $this->assertSame('sturple@fifthgeardev.com',$to[0]->address);
        $this->assertSame('Shawn Turple',$to[0]->name);
        $cc = $submission->getCc();
        $this->assertCount(0,$cc);
        $bcc = $submission->getBcc();
        $this->assertSame('foo@example.org',$bcc[0]->address);
        $this->assertFalse(isset($bcc[0]->name));
        $this->assertSame($this->form,$submission->getForm());
        $this->assertSame('',$submission->getSubject());
        //  TODO: Verify body
        //  Verify interaction with MockField objects
        $this->assertTrue($field_object_a->isRendered());
        $this->assertTrue($field_object_b->isRendered());
        $this->assertSame($request,$field_object_a->getRequest());
        $this->assertSame($request,$field_object_b->getRequest());
        $this->assertSame($submission,$field_object_a->getSubmission());
        $this->assertSame($submission,$field_object_b->getSubmission());
        $this->assertSame($msg,$field_object_a->getMessage());
        $this->assertSame($msg,$field_object_b->getMessage());
    }
}
