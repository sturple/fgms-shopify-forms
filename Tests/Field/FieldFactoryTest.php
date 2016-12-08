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
}
