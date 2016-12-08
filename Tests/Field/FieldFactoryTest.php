<?php

namespace Fgms\EmailInquiriesBundle\Tests\Field;

class FieldFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $factory;
    private $field;

    protected function setUp()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Array());
        $this->factory = new \Fgms\EmailInquiriesBundle\Field\FieldFactory($twig);
        $this->field = new \Fgms\EmailInquiriesBundle\Entity\Field();
    }

    private function create()
    {
        return $this->factory->create($this->field);
    }

    public function testCreateUnrecognized()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Field\Exception\UnrecognizedTypeException::class);
        $this->field->setType('');  //  Just make sure the type isn't null since that should never happen...
        $this->create();
    }

    public function testCreateEmail()
    {
        $this->field->setType('email');
        $field = $this->create();
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Field\EmailField::class,$field);
        $this->assertSame($this->field,$field->getField());
    }

    public function testCreateInquiry()
    {
        $this->field->setType('inquiry');
        $field = $this->create();
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Field\InquiryField::class,$field);
        $this->assertSame($this->field,$field->getField());
    }

    public function testCreateName()
    {
        $this->field->setType('name');
        $field = $this->create();
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Field\NameField::class,$field);
        $this->assertSame($this->field,$field->getField());
    }
}
