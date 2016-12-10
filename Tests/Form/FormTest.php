<?php

namespace Fgms\EmailInquiriesBundle\Tests\Form;

class FormTest extends \PHPUnit_Framework_TestCase
{
    private $swift;
    private $form;
    private $factory;
    private $twig;

    protected function setUp()
    {
        $this->form = new \Fgms\EmailInquiriesBundle\Entity\Form();
        $this->swift = new \Fgms\EmailInquiriesBundle\Swift\MockTransport();
        $this->factory = new \Fgms\EmailInquiriesBundle\Field\MockFieldFactory();
        $this->twig = new \Twig_Loader_Array([
            'test.txt.twig' => '{% for section in sections %}{{section|raw}}{% endfor %}'
        ]);
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
            ],
            'template' => 'test.txt.twig'
        ],$params);
        $this->form->setParams((object)$params);
        $swift = \Swift_Mailer::newInstance($this->swift);
        $twig = new \Twig_Environment($this->twig);
        return new \Fgms\EmailInquiriesBundle\Form\Form(
            $this->form,
            $this->factory,
            $swift,
            $twig
        );
    }

    public function testSubmit()
    {
        $field_entity_a = $this->createField(1,'foo',1);
        $field_object_a = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_a);
        $field_object_a->setRender([
            'foo',
            'bar'
        ]);
        $this->factory->addField($field_object_a);
        $this->form->addField($field_entity_a);
        $field_entity_b = $this->createField(2,'bar',0);
        $field_object_b = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_b);
        $field_object_b->setRender([
            'corge'
        ]);
        $this->factory->addField($field_object_b);
        $this->form->addField($field_entity_b);
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $dt = new \DateTime();
        $submission->setIp('127.0.0.1')
            ->setCreated(clone $dt)
            ->setReferer('http://google.ca');
        $form = $this->create();
        $request = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(new \stdClass());
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
        $this->assertSame('UTF-8',$msg->getCharset());
        $this->assertSame('text/plain',$msg->getContentType());
        $body = 'corgefoobar';
        $this->assertSame($body,$msg->getBody());
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
        $this->assertCount(1,$bcc);
        $this->assertSame('foo@example.org',$bcc[0]->address);
        $this->assertFalse(isset($bcc[0]->name));
        $reply_to = $submission->getReplyTo();
        $this->assertCount(0,$reply_to);
        $sender = $submission->getSender();
        $this->assertCount(0,$sender);
        $this->assertSame($this->form,$submission->getForm());
        $this->assertSame('',$submission->getSubject());
        $this->assertSame($body,$submission->getBody());
        $this->assertNotEmpty($submission->getHeaders());
        //  Verify interaction with MockField objects
        $this->assertTrue($field_object_a->isRendered());
        $this->assertTrue($field_object_b->isRendered());
        $this->assertSame($request->unwrap(),$field_object_a->getRequest()->unwrap());
        $this->assertSame($request->unwrap(),$field_object_b->getRequest()->unwrap());
        $this->assertSame($submission,$field_object_a->getSubmission());
        $this->assertSame($submission,$field_object_b->getSubmission());
        $this->assertSame($msg,$field_object_a->getMessage());
        $this->assertSame($msg,$field_object_b->getMessage());
    }

    public function testSubmitContentTypeDetectHtml()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $submission->setIp('127.0.0.1')
            ->setCreated(new \DateTime())
            ->setReferer('http://google.ca');
        $form = $this->create([
            'template' => 'test.html.twig'
        ]);
        $this->twig->setTemplate('test.html.twig','');
        $request = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(new \stdClass());
        $form->submit($request,$submission);
        //  Verify content-type
        $msgs = $this->swift->getMessages();
        $this->assertCount(1,$msgs);
        $msg = $msgs[0];
        $this->assertSame('text/html',$msg->getContentType());
    }

    public function testSubmitContentType()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $submission->setIp('127.0.0.1')
            ->setCreated(new \DateTime())
            ->setReferer('http://google.ca');
        $form = $this->create([
            'content_type' => 'foo'
        ]);
        $this->twig->setTemplate('test.html.twig','');
        $request = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(new \stdClass());
        $form->submit($request,$submission);
        //  Verify content-type
        $msgs = $this->swift->getMessages();
        $this->assertCount(1,$msgs);
        $msg = $msgs[0];
        $this->assertSame('foo',$msg->getContentType());
    }

    public function testSubmitCharset()
    {
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $submission->setIp('127.0.0.1')
            ->setCreated(new \DateTime())
            ->setReferer('http://google.ca');
        $form = $this->create([
            'charset' => 'ASCII'
        ]);
        $this->twig->setTemplate('test.html.twig','');
        $request = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(new \stdClass());
        $form->submit($request,$submission);
        //  Verify content-type
        $msgs = $this->swift->getMessages();
        $this->assertCount(1,$msgs);
        $msg = $msgs[0];
        $this->assertSame('ASCII',$msg->getCharset());
    }

    public function testGetHeadings()
    {
        $field_entity_a = $this->createField(1,'foo',0);
        $field_object_a = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_a);
        $field_object_a->setHeadings(['foo','bar']);
        $this->factory->addField($field_object_a);
        $this->form->addField($field_entity_a);
        $field_entity_b = $this->createField(2,'bar',1);
        $field_object_b = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_b);
        $field_object_b->setHeadings(['corge']);
        $this->factory->addField($field_object_b);
        $this->form->addField($field_entity_b);
        $form = $this->create();
        $arr = $form->getHeadings();
        $this->assertCount(5,$arr);
        $this->assertArrayHasKey(0,$arr);
        $this->assertSame('ID',$arr[0]);
        $this->assertArrayHasKey(1,$arr);
        $this->assertSame('Date & Time',$arr[1]);
        $this->assertArrayHasKey(2,$arr);
        $this->assertSame('foo',$arr[2]);
        $this->assertArrayHasKey(3,$arr);
        $this->assertSame('bar',$arr[3]);
        $this->assertArrayHasKey(4,$arr);
        $this->assertSame('corge',$arr[4]);
    }

    public function testGetRows()
    {
        $field_entity_a = $this->createField(1,'foo',0);
        $field_object_a = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_a);
        $field_object_a->addRow(['foo','bar']);
        $this->factory->addField($field_object_a);
        $this->form->addField($field_entity_a);
        $field_entity_b = $this->createField(2,'bar',1);
        $field_object_b = new \Fgms\EmailInquiriesBundle\Field\MockField($field_entity_b);
        $field_object_b->addRow(['corge']);
        $this->factory->addField($field_object_b);
        $this->form->addField($field_entity_b);
        $form = $this->create();
        $submission = new \Fgms\EmailInquiriesBundle\Entity\Submission();
        $rc = new \ReflectionClass($submission);
        $prop = $rc->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($submission,6);
        $submission->setCreated(\DateTime::createFromFormat('U','0'));
        $row = $form->getRow($submission);
        $this->assertCount(5,$row);
        $this->assertArrayHasKey(0,$row);
        $this->assertSame('6',$row[0]);
        $this->assertArrayHasKey(1,$row);
        $this->assertSame('Jan 1, 1970 12:00:00 AM UTC',$row[1]);
        $this->assertArrayHasKey(2,$row);
        $this->assertSame('foo',$row[2]);
        $this->assertArrayHasKey(3,$row);
        $this->assertSame('bar',$row[3]);
        $this->assertArrayHasKey(4,$row);
        $this->assertSame('corge',$row[4]);
    }
}
