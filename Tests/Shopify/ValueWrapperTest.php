<?php

namespace Fgms\EmailInquiriesBundle\Tests\Shopify;

class ValueWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $wrapper;

    protected function setUp()
    {
        $inner = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)[
            'foo' => 'bar'
        ]);
        $this->wrapper = new \Fgms\EmailInquiriesBundle\Shopify\ValueWrapper($inner);
    }

    public function testMissing()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Shopify\Exception\MissingException::class);
        $this->wrapper->getString('baz');
    }

    public function testTypeMismatch()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Shopify\Exception\TypeMismatchException::class);
        $this->wrapper->getInteger('foo');
    }

    public function testCreate()
    {
        $obj = \Fgms\EmailInquiriesBundle\Shopify\ValueWrapper::create('{"foo":"bar"}');
        $this->assertSame('bar',$obj->getString('foo'));
    }

    public function testCreateInvalid()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Shopify\Exception\DecodeException::class);
        \Fgms\EmailInquiriesBundle\Shopify\ValueWrapper::create('{');
    }

    public function testCreateNonObject()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Shopify\Exception\DecodeException::class);
        \Fgms\EmailInquiriesBundle\Shopify\ValueWrapper::create('[]');
    }
}
