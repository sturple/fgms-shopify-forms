<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * A convenience base class for fields which
 * extract a single field from the request which
 * they expect to be a string.
 */
abstract class StringField extends Field
{
	private $name;

	/**
	 * Creates a new StringField object.
	 *
	 * @param Field $field
	 *  Will be passed through to the parent constructor.
	 * @param string $name_key
	 *  The configuration key to use for the name.  Defaults
	 *  to &quot;name&quot;.
	 */
	public function __construct(\Fgms\EmailInquiriesBundle\Entity\Field $field, $name_key = 'name')
	{
		parent::__construct($field);
		$this->name = $field->getParams()->getString($name_key);
	}

	protected function getValue(\Fgms\EmailInquiriesBundle\Utility\ValueWrapper $obj)
	{
		return $obj->getString($this->name);
	}
}
