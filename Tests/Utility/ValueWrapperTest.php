<?php

namespace Fgms\EmailInquriesBundle\Tests\Utility;

class ValueWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInherit()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(['baz']);
        $c = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(['corge','quux']);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getInteger('foo',$a,$b,$c);
        $this->assertSame(5,$val);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString(0,$a,$b,$c);
        $this->assertSame('baz',$val);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString(1,$a,$b,$c);
        $this->assertSame('quux',$val);
    }

    public function testGetInheritMismatch()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['foo' => 'bar']);
        $this->expectThrows();
        \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString('foo',$a,$b);
    }

    public function testGetInheritMissing()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['bar' => 'baz']);
        $this->expectThrows();
        \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getString('baz',$a,$b);
    }

    public function testGetOptionalFromObject()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['bar' => 'baz']);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getOptionalString('bar',$a,$b);
        $this->assertSame('baz',$val);
    }

    public function testGetOptionalMissingFromObject()
    {
        $a = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['foo' => 5]);
        $b = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl((object)['bar' => 'baz']);
        $val = \Fgms\EmailInquiriesBundle\Utility\ValueWrapper::getOptionalString('baz',$a,$b);
        $this->assertNull($val);
    }

    private function expectThrows()
    {
        $this->expectException(\LogicException::class);
    }

    private function create($str = '{}')
    {
        return new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(
			\Fgms\EmailInquiriesBundle\Json\Json::decodeRaw($str)
		);
    }

    public function testGetString()
    {
        $obj = $this->create('{"test":"foo"}');
        $str = $obj->getString('test');
        $this->assertSame('foo',$str);
    }

    public function testGetStringEmpty()
    {
        $obj = $this->create();
        $this->expectThrows();
        $obj->getString('test');
    }

    public function testGetStringMismatch()
    {
        $obj = $this->create('{"test":5}');
        $this->expectThrows();
        $obj->getString('test');
    }

    public function testGetOptionalString()
    {
        $obj = $this->create('{"foo":"bar"}');
        $str = $obj->getOptionalString('foo');
        $this->assertSame('bar',$str);
    }

    public function testGetOptionalStringEmpty()
    {
        $obj = $this->create();
        $str = $obj->getOptionalString('bar');
        $this->assertNull($str);
    }

    public function testGetOptionalStringMismatch()
    {
        $obj = $this->create('{"quux":17.2}');
        $this->expectThrows();
        $obj->getOptionalString('quux');
    }

    public function testGetObject()
    {
        $obj = $this->create('{"test":{"foo":"bar"}}');
        $o = $obj->getObject('test');
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$o);
        $this->assertSame('bar',$o->getString('foo'));
    }

    public function testGetObjectEmpty()
    {
        $obj = $this->create();
        $this->expectThrows();
        $obj->getObject('test');
    }

    public function testGetObjectMismatch()
    {
        $obj = $this->create('{"test":5}');
        $this->expectThrows();
        $obj->getObject('test');
    }

    public function testGetOptionalObject()
    {
        $obj = $this->create('{"test":{"foo":"bar"}}');
        $o = $obj->getOptionalObject('test');
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$o);
        $this->assertSame('bar',$o->getString('foo'));
    }

    public function testGetOptionalObjectEmpty()
    {
        $obj = $this->create();
        $o = $obj->getOptionalObject('bar');
        $this->assertNull($o);
    }

    public function testGetOptionalObjectMismatch()
    {
        $obj = $this->create('{"quux":17.2}');
        $this->expectThrows();
        $obj->getOptionalObject('quux');
    }

    public function testGetInteger()
    {
        $obj = $this->create('{"test":5}');
        $this->assertSame(5,$obj->getInteger('test'));
    }

    public function testGetIntegerEmpty()
    {
        $obj = $this->create();
        $this->expectThrows();
        $obj->getInteger('test');
    }

    public function testGetIntegerMismatch()
    {
        $obj = $this->create('{"test":5.2}');
        $this->expectThrows();
        $obj->getInteger('test');
    }

    public function testGetOptionalInteger()
    {
        $obj = $this->create('{"test":5}');
        $this->assertSame(5,$obj->getOptionalInteger('test'));
    }

    public function testGetOptionalIntegerEmpty()
    {
        $obj = $this->create();
        $this->assertNull($obj->getOptionalInteger('bar'));
    }

    public function testGetOptionalIntegerMismatch()
    {
        $obj = $this->create('{"quux":17.2}');
        $this->expectThrows();
        $obj->getOptionalInteger('quux');
    }

	public function testGetNull()
	{
		$obj = $this->create('{"foo":null}');
		$val = $obj->getNull('foo');
		$this->assertNull($val);
	}

	public function testGetNullMissing()
	{
		$obj = $this->create('{}');
		$this->expectThrows();
		$obj->getNull('foo');
	}

	public function testGetMultiple()
	{
		$obj = $this->create('{"foo":5}');
		$val = $obj->getStringOrInteger('foo');
		$this->assertSame(5,$val);
	}

	public function testGetMultipleMismatch()
	{
		$obj = $this->create('{"foo":5}');
		$this->expectThrows();
		$obj->getStringOrArray('foo');
	}

    private $arr;

    protected function setUp()
    {
        $this->arr = new \Fgms\EmailInquiriesBundle\Utility\ValueWrapperImpl(
            ['foo',new \stdClass(),[]],
            '["foo",{},[]]',
            ''
        );
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
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$arr[1]);
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$arr[2]);
    }

    public function testOffsetExists()
    {
        $this->assertTrue(isset($this->arr[0]));
        $this->assertFalse(isset($this->arr[4]));
    }

    public function testOffsetGet()
    {
        $this->assertSame('foo',$this->arr[0]);
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$this->arr[1]);
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
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$this->arr->getObject(1));
    }

    public function testGetMissing()
    {
        $this->expectThrows();
        $this->arr->getObject(4);
    }

    public function testGetOptionalFromArray()
    {
        $this->assertInstanceOf(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper::class,$this->arr->getOptionalArray(2));
    }

    public function testGetOptionalMissingFromArray()
    {
        $this->assertNull($this->arr->getOptionalInteger(5));
    }
}
