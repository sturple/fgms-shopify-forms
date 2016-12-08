<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * A mixin for fields which extract a single field
 * from the request which they expect to be a string.
 */
trait StringField
{
	private function getValue(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj)
	{
		$name = $this->getField()->getParams()->getString('name');
		return $obj->getString($name);
	}
}
