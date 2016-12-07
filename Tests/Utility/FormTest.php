<?php

namespace Fgms\EmailInquiriesBundle\Tests\Utility;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testDecodeEmpty()
    {
        $obj = \Fgms\EmailInquiriesBundle\Utility\Form::decode('');
        $this->assertCount(0,get_object_vars($obj));
    }

    public function testDecode()
    {
        $obj = \Fgms\EmailInquiriesBundle\Utility\Form::decode('foo=bar&baz=quux');
        $vars = get_object_vars($obj);
        $this->assertCount(2,$vars);
        $this->assertArrayHasKey('foo',$vars);
        $this->assertSame('bar',$obj->foo);
        $this->assertArrayHasKey('baz',$vars);
        $this->assertSame('quux',$obj->baz);
    }

    public function testDecodeArray()
    {
        $obj = \Fgms\EmailInquiriesBundle\Utility\Form::decode('foo=bar&baz=quux&baz=corge&baz=hello%20world');
        $vars = get_object_vars($obj);
        $this->assertCount(2,$vars);
        $this->assertArrayHasKey('foo',$vars);
        $this->assertSame('bar',$obj->foo);
        $this->assertArrayHasKey('baz',$vars);
        $arr = $obj->baz;
        $this->assertCount(3,$arr);
        $this->assertArrayHasKey(0,$arr);
        $this->assertSame('quux',$arr[0]);
        $this->assertArrayHasKey(1,$arr);
        $this->assertSame('corge',$arr[1]);
        $this->assertArrayHasKey(2,$arr);
        $this->assertSame('hello world',$arr[2]);
    }

    public function testDecodeBad()
    {
        $this->expectException(\Fgms\EmailInquiriesBUndle\Utility\Exception\FormDecodeException::class);
        \Fgms\EmailInquiriesBundle\Utility\Form::decode('foo');
    }
}
