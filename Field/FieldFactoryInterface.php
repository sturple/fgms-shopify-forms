<?php

namespace Fgms\EmailInquiriesBundle\Field;

/**
 * An interface which may be implemented to provide
 * FieldInterface instances which encapsulate the logic
 * of Field entities.
 */
interface FieldFactoryInterface
{
	/**
	 * Creates a FieldInterface instance which encapsulates
	 * the logic of a Field entity.
	 *
	 * @param Field $field
	 *
	 * @return FieldInterface
	 */
	public function create(\Fgms\EmailInquiriesBundle\Entity\Field $field);
}
