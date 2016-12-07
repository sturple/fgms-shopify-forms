<?php

namespace Fgms\EmailInquiriesBundle\Tests\Utility;

class ArrayWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $arr;

    protected function setUp()
    {
        $this->arr = new \Fgms\EmailInquiriesBundle\Utility\BasicArrayWrapper(
            ['foo',new \stdClass(),[]],
            '["foo",{},[]]',
            ''
        );
    }

    private function expectMissing()
    {
        $this->expectException(\LogicException::class);
    }

    public function testCount()
    {
        $this->assertCount(3,$this->arr);
    }

    public function testGetIterator()
    {
        $arr = iterator_to_array($this->arr);
        $this->assertCount(3,$arr);
        $this->assertSame('foo',$arr[0]);
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ObjectWrapper::class,$arr[1]);
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ArrayWrapper::class,$arr[2]);
    }

    public function testOffsetExists()
    {
        $this->assertTrue(isset($this->arr[0]));
        $this->assertFalse(isset($this->arr[4]));
    }

    public function testOffsetGet()
    {
        $this->assertSame('foo',$this->arr[0]);
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ObjectWrapper::class,$this->arr[1]);
    }

    public function testOffsetSet()
    {
        $this->expectException(\LogicException::class);
        $this->arr->offsetSet(0,'bar');
    }

    public function testOffsetUnset()
    {
        $this->expectException(\LogicException::class);
        $this->arr->offsetUnset(0);
    }

    public function testGet()
    {
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ObjectWrapper::class,$this->arr->getObject(1));
    }

    public function testGetMissing()
    {
        $this->expectMissing();
        $this->arr->getObject(4);
    }

    public function testGetOptional()
    {
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ArrayWrapper::class,$this->arr->getOptionalArray(2));
    }

    public function testGetOptionalMissing()
    {
        $this->assertNull($this->arr->getOptionalInteger(5));
    }
}
