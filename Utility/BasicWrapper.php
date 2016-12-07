<?php

namespace Fgms\EmailInquiriesBundle\Utility;

trait BasicWrapper
{
    protected function raiseTypeMismatch($key, $expected, $actual)
	{
		throw new \LogicException('Type mismatch');
	}

	protected function raiseMissing($key)
	{
		throw new \LogicException('Missing');
	}
}
