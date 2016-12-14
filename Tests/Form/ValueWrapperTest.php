<?php

namespace Fgms\EmailInquiriesBundle\Tests\Form;

class ValueWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $wrapper;

    protected function setUp()
    {
        $inner = new \Fgms\ValueWrapper\ValueWrapperImpl((object)[
            'foo' => 'bar'
        ]);
        $this->wrapper = new \Fgms\EmailInquiriesBundle\Form\ValueWrapper($inner);
    }

    public function testMissing()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Form\Exception\MissingException::class);
        $this->wrapper->getString('baz');
    }

    public function testTypeMismatch()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Form\Exception\TypeMismatchException::class);
        $this->wrapper->getInteger('foo');
    }
}
