<?php

namespace Fgms\EmailInquiriesBundle\Form;

trait Wrapper
{
    private $inner;

    public function unwrap()
    {
        return $this->inner->unwrap();
    }

    public function raiseMissing($key)
    {
        try {
            $this->inner->raiseMissing($key);
        } catch (\Exception $ex) {
            throw new Exception\MissingException($key,$ex);
        }
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        try {
            $this->inner->raiseTypeMismatch($key,$expected,$actual);
        } catch (\Exception $ex) {
            throw new Exception\TypeMismatchException($key,$expected,$actual,$ex);
        }
    }

    public function check($key, array $types)
    {
        return $this->inner->check($key,$types);
    }

    public function get($key, array $types)
    {
        return $this->inner->get($key,$types);
    }

    public function wrapArray($key, array $value)
    {
        return new ArrayWrapper($this->inner->wrapArray($key,$value));
    }

    public function wrapObject($key, $value)
    {
        return new ObjectWrapper($this->inner->wrapObject($key,$value));
    }
}
