<?php

namespace Fgms\EmailInquriesBundle\Tests\Utility;

class ValueWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInherit()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\BasicArrayWrapper(['baz']);
        $c = new \Fgms\EmailInquiriesBundle\Utility\BasicArrayWrapper(['corge','quux']);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getInteger('foo',$a,$b,$c);
        $this->assertSame(5,$val);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString(0,$a,$b,$c);
        $this->assertSame('baz',$val);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString(1,$a,$b,$c);
        $this->assertSAme('quux',$val);
    }

    public function testGetInheritMismatch()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['foo' => 'bar']);
        $this->expectException(\LogicException::class);
        \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString('foo',$a,$b);
    }

    public function testGetInheritMissing()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['bar' => 'baz']);
        $this->expectException(\LogicException::class);
        \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString('baz',$a,$b);
    }

    public function testGetOptional()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['bar' => 'baz']);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getOptionalString('bar',$a,$b);
        $this->assertSame('baz',$val);
    }

    public function testGetOptionalMissing()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\BasicObjectWrapper((object)['bar' => 'baz']);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getOptionalString('baz',$a,$b);
        $this->assertNull($val);
    }
}
