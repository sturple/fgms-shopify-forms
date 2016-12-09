<?php

namespace Fgms\EmailInquiriesBundle\Field\Exception;

/**
 * Thrown when a HoneypotField object detects
 * that the submission was submitted by a bot.
 */
class HoneypotException extends DataException
{
}
